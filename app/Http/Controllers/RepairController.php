<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use App\Models\RepairStatusHistory;
use App\Models\SiteSetting;
use App\Services\TrackingIdService;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'delivery_method' => ['required', 'in:drop-off,courier'],
            'device_brand' => ['required', 'string', 'max:255'],
            'device_model' => ['required', 'string', 'max:255'],
            'issue' => ['required', 'string', 'max:1000'],
            'device_photo' => ['required', 'image', 'max:4096'],
            'disclaimer_accepted' => ['accepted'],
        ]);

        $photoPath = $request->file('device_photo')->store('repair-photos', 'public');

        $repair = Repair::create([
            'tracking_id' => TrackingIdService::generate(),
            'user_id' => auth()->id(),
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'delivery_method' => $validated['delivery_method'],
            'device_brand' => $validated['device_brand'],
            'device_model' => $validated['device_model'],
            'issue' => $validated['issue'],
            'device_photo' => $photoPath,
            'disclaimer_accepted_at' => now(),
            'status' => 'requested',
        ]);

        RepairStatusHistory::create([
            'repair_id' => $repair->id,
            'old_status' => null,
            'new_status' => 'requested',
            'note' => 'Repair request submitted by customer. Disclaimer accepted.',
            'changed_by' => auth()->id(),
        ]);

        if (auth()->user() && ! auth()->user()->phone) {
            auth()->user()->update(['phone' => $validated['customer_phone']]);
        }

        $adminNumber = SiteSetting::get('admin_whatsapp_number');
        $message = "New repair request:\n"
            . "Tracking ID: {$repair->tracking_id}\n"
            . "Customer: {$repair->customer_name}\n"
            . "Phone: {$repair->customer_phone}\n"
            . "Device: {$repair->device_brand} {$repair->device_model}\n"
            . "Issue: {$repair->issue}\n"
            . "Delivery: {$repair->deliveryMethodLabel()}\n"
            . "A photo of the device has been uploaded — please check the repair in the admin panel.";

        $whatsappUrl = 'https://wa.me/' . $adminNumber . '?text=' . urlencode($message);

        return redirect()->route('repairs.confirmation', $repair->tracking_id)
            ->with('whatsapp_url', $whatsappUrl);
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

        $repair->load('statusHistories', 'user', 'delivery');

        $qrCode = QrCode::size(150)->generate(route('repairs.track.result.direct', $repair->tracking_id));

        return view('repairs.track-result', ['repair' => $repair, 'qrCode' => $qrCode]);
    }

    // Direct tracking view by tracking ID — used by QR codes and after approval
    public function trackDirect(string $trackingId)
    {
        $repair = Repair::where('tracking_id', $trackingId)->first();

        if (! $repair) {
            abort(404, 'No repair found with this tracking ID.');
        }

        $repair->load('statusHistories', 'user', 'delivery');

        $qrCode = QrCode::size(150)->generate(route('repairs.track.result.direct', $repair->tracking_id));

        return view('repairs.track-result', ['repair' => $repair, 'qrCode' => $qrCode]);
    }
}