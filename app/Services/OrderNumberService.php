<?php

namespace App\Services;

use App\Models\Order;

class OrderNumberService
{
    /**
     * Generate a unique order number in the format: ORD-YYYYMMDD-XXXX
     */
    public static function generate(): string
    {
        $datePart = now()->format('Ymd');

        do {
            $sequence = str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
            $orderNumber = "ORD-{$datePart}-{$sequence}";
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}