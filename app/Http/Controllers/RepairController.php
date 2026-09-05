<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use App\Models\RepairStatusHistory;
use App\Services\TrackingIdService;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    // Show the "Book Repair" form
    public function create()
    {
        return view('repairs.create');
    }

    // Handle form submission and create the repair
    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_brand' => ['required', 'string', 'max:255'],
            'device_model' => ['required', 'string', 'max:255'],
            'issue' => ['required', 'string', 'max:1000'],
        ]);

        $repair = Repair::create([
            'tracking_id' => TrackingIdService::generate(),
            'user_id' => auth()->id(),
            'device_brand' => $validated['device_brand'],
            'device_model' => $validated['device_model'],
            'issue' => $validated['issue'],
            'status' => 'requested',
        ]);

        // Log the very first status entry, so the timeline always has a starting point
        RepairStatusHistory::create([
            'repair_id' => $repair->id,
            'old_status' => null,
            'new_status' => 'requested',
            'note' => 'Repair request submitted by customer.',
            'changed_by' => auth()->id(),
        ]);

        return redirect()->route('repairs.confirmation', $repair->tracking_id);
    }

    // Show confirmation page with the tracking ID
    public function confirmation(string $trackingId)
    {
        $repair = Repair::where('tracking_id', $trackingId)->firstOrFail();

        return view('repairs.confirmation', ['repair' => $repair]);
    }
}