<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use App\Models\RepairStatusHistory;
use Illuminate\Http\Request;

class RepairApprovalController extends Controller
{
    // Show the "enter your OTP" form for a given tracking ID
    public function show(string $trackingId)
    {
        $repair = Repair::where('tracking_id', $trackingId)->firstOrFail();

        abort_unless($repair->needsApproval(), 404);

        return view('repairs.approve', ['repair' => $repair]);
    }

    // Verify the submitted OTP
    public function verify(Request $request, string $trackingId)
    {
        $repair = Repair::where('tracking_id', $trackingId)->firstOrFail();

        $request->validate([
            'otp_code' => ['required', 'string'],
        ]);

        if ($repair->isApproved()) {
            return redirect()->route('repairs.track.result.direct', $repair->tracking_id);
        }

        if ($repair->otp_expires_at && $repair->otp_expires_at->isPast()) {
            return back()->withErrors(['otp_code' => 'This code has expired. Please ask the shop to resend it.']);
        }

        if ($request->otp_code !== $repair->otp_code) {
            return back()->withErrors(['otp_code' => 'Incorrect code. Please try again.']);
        }

        $repair->update(['approved_at' => now()]);

        RepairStatusHistory::create([
            'repair_id' => $repair->id,
            'old_status' => $repair->status,
            'new_status' => $repair->status,
            'note' => 'Customer approved the repair via email verification.',
            'changed_by' => null,
        ]);

        return redirect()->route('repairs.track.result.direct', $repair->tracking_id)
            ->with('status', 'Thank you — your repair has been approved.');
    }
}