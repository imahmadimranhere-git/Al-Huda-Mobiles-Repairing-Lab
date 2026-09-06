<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TechnicianController extends Controller
{
    // List all technicians
    public function index()
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $technicians = User::whereHas('role', fn ($q) => $q->where('slug', 'technician'))
            ->latest()
            ->get();

        return view('admin.technicians.index', ['technicians' => $technicians]);
    }

    // Show "Add Technician" form
    public function create()
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        return view('admin.technicians.create');
    }

    // Handle new technician creation
    public function store(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $technicianRole = Role::where('slug', 'technician')->first();

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role_id' => $technicianRole->id,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.technicians.index')->with('status', 'Technician added successfully.');
    }

    // Show "Edit Technician" form
    public function edit(User $technician)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');
        abort_unless($technician->isTechnician(), 404);

        return view('admin.technicians.edit', ['technician' => $technician]);
    }

    // Handle technician update
    public function update(Request $request, User $technician)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');
        abort_unless($technician->isTechnician(), 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $technician->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        $technician->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => $validated['password'] ? Hash::make($validated['password']) : $technician->password,
        ]);

        return redirect()->route('admin.technicians.index')->with('status', 'Technician updated successfully.');
    }

    // Toggle active/inactive (instead of deleting, so past repairs stay linked)
    public function toggleStatus(User $technician)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');
        abort_unless($technician->isTechnician(), 404);

        $technician->update(['is_active' => ! $technician->is_active]);

        return back()->with('status', 'Technician status updated.');
    }
}