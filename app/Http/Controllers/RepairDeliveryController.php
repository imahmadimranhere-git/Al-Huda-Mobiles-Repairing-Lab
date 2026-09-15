<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use App\Models\RepairDelivery;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class RepairDeliveryController extends Controller
{
    // Store the customer's "I received my device" confirmation + required photo.
    // The liability disclaimer was already accepted when the repair was booked,
    // so only the photo is required here.
    public function store(Request $request, string $trackingId)
    {
        $repair = Repair::where('tracking_id', $trackingId)->firstOrFail();

        $validated = $request->validate([
            'photo' => ['required', 'image', 'max:4096'],
        ]);

        $photoPath = $request->file('photo')->store('deliveries', 'public');

        RepairDelivery::updateOrCreate(
            ['repair_id' => $repair->id],
            ['photo' => $photoPath, 'disclaimer_accepted' => true]
        );

        $adminNumber = SiteSetting::get('admin_whatsapp_number');
        $message = "Device received confirmation:\n"
            . "Tracking ID: {$repair->tracking_id}\n"
            . "Customer: {$repair->user->name}\n"
            . "Device: {$repair->device_brand} {$repair->device_model}\n"
            . "A photo has been uploaded — please check the repair in the admin panel.";

        $whatsappUrl = 'https://wa.me/' . $adminNumber . '?text=' . urlencode($message);

        return redirect()->route('repairs.track.result.direct', $repair->tracking_id)
            ->with('status', 'Thank you for confirming. Please tap the WhatsApp button to notify us.')
            ->with('whatsapp_url', $whatsappUrl);
    }
}