<?php

namespace App\Services;

use App\Models\Repair;
use Illuminate\Support\Str;

class TrackingIdService
{
    /**
     * Generate a unique tracking ID in the format: AHMR-YYYYMMDD-XXXX
     * Example: AHMR-20260905-0001
     */
    public static function generate(): string
    {
        $datePart = now()->format('Ymd');

        do {
            $sequence = str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
            $trackingId = "AHMR-{$datePart}-{$sequence}";
        } while (Repair::where('tracking_id', $trackingId)->exists());

        return $trackingId;
    }
}