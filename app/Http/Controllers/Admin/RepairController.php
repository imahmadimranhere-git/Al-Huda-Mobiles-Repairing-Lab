<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Repair;
use App\Models\RepairStatusHistory;
use App\Models\Role;
use App\Models\User;
use App\Services\TrackingIdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RepairController extends Controller
{
    private const STATUSES = [
        'requested',
        'received',
        'diagnosed',
        'repairing',
        'ready-for-pickup',
        'completed',
        'cancelled',
    ];

    // List all repairs, newest first, with basic search
    public function index(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $query = Repair::with('user', 'technician')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tracking_id', 'like', "%{$search}%")
                  ->orWhere('device_brand', 'like', "%{$search}%")
                  ->orWhere('device_model', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $repairs = $query->paginate(10)->withQueryString();

        return view('admin.repairs.index', [
            'repairs' => $repairs,
            'statuses' => self::STATUSES,
        ]);
    }

    // Show a single repair with full detail + timeline
    public function show(Repair $repair)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $repair->load('user', 'technician', 'statusHistories.changedBy');

        $technicians = User::whereHas('role', fn ($q) => $q->where('slug', 'technician'))->get();

        return view('admin.repairs.show', [
            'repair' => $repair,
            'statuses' => self::STATUSES,
            'technicians' => $technicians,
        ]);
    }

    // Update a repair's status and log it in the history table
    public function updateStatus(Request $request, Repair $repair)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $validated = $request->validate([
            'status' => ['required', 'in:' . implode(',', self::STATUSES)],
            'technician_id' => ['nullable', 'exists:users,id'],
            'note' => ['nullable', 'string', 'max:500'],
            'diagnosis' => ['nullable', 'string', 'max:1000'],
            'estimated_cost' => ['nullable', 'numeric', 'min:0'],
            'final_cost' => ['nullable', 'numeric', 'min:0'],
        ]);

        $oldStatus = $repair->status;

        $repair->update([
            'status' => $validated['status'],
            'technician_id' => $validated['technician_id'] ?? $repair->technician_id,
            'diagnosis' => $validated['diagnosis'] ?? $repair->diagnosis,
            'estimated_cost' => $validated['estimated_cost'] ?? $repair->estimated_cost,
            'final_cost' => $validated['final_cost'] ?? $repair->final_cost,
        ]);

        if ($oldStatus !== $validated['status']) {
            RepairStatusHistory::create([
                'repair_id' => $repair->id,
                'old_status' => $oldStatus,
                'new_status' => $validated['status'],
                'note' => $validated['note'] ?? null,
                'changed_by' => auth()->id(),
            ]);
        }

        return back()->with('status', 'Repair updated successfully.');
    }

    // Show the walk-in repair entry form
    public function walkInCreate()
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        return view('admin.repairs.walk-in');
    }

    // Handle walk-in repair submission
    public function walkInStore(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'device_brand' => ['required', 'string', 'max:255'],
            'device_model' => ['required', 'string', 'max:255'],
            'issue' => ['required', 'string', 'max:1000'],
        ]);

        $customer = User::where('phone', $validated['phone'])->first();

        if (! $customer) {
            $customerRole = Role::where('slug', 'user')->first();

            $customer = User::create([
                'name' => $validated['customer_name'],
                'email' => 'walkin_' . Str::random(10) . '@alhudarepair.local',
                'phone' => $validated['phone'],
                'password' => Hash::make(Str::random(16)),
                'role_id' => $customerRole?->id,
            ]);
        }

        $repair = Repair::create([
            'tracking_id' => TrackingIdService::generate(),
            'user_id' => $customer->id,
            'device_brand' => $validated['device_brand'],
            'device_model' => $validated['device_model'],
            'issue' => $validated['issue'],
            'status' => 'received',
        ]);

        RepairStatusHistory::create([
            'repair_id' => $repair->id,
            'old_status' => null,
            'new_status' => 'received',
            'note' => 'Walk-in repair created by ' . auth()->user()->name,
            'changed_by' => auth()->id(),
        ]);

        return redirect()->route('admin.repairs.show', $repair)
            ->with('status', 'Walk-in repair created. Tracking ID: ' . $repair->tracking_id);
    }
}