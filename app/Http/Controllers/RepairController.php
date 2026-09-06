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

    // Show the "Track Repair" search form
    public function trackForm()
    {
        return view('repairs.track');
    }

    // Handle tracking ID search and show status
    public function trackResult(Request $request)
    {
        $request->validate([
            'tracking_id' => ['required', 'string'],
        ]);

        $repair = Repair::where('tracking_id', $request->tracking_id)->first();

        if (! $repair) {
            return back()->withErrors(['tracking_id' => 'No repair found with this tracking ID.']);
        }

        $repair->load('statusHistories');

        return view('repairs.track-result', ['repair' => $repair]);
    }
}