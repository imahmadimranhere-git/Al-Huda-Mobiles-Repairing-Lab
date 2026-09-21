<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Repair;
use Illuminate\Console\Command;

class DeleteOldOrders extends Command
{
    protected $signature = 'orders:cleanup';

    protected $description = 'Delete completed/cancelled orders and completed/cancelled repairs older than 1 month';

    public function handle(): void
    {
        // updated_at reflects when the record's status was last changed,
        // so a month from that point is the fairest measure of
        // "1 month after completion".
        $cutoff = now()->subMonth();

        // ---- Orders ----
        $orders = Order::whereIn('status', ['completed', 'cancelled'])
            ->where('updated_at', '<', $cutoff)
            ->get();

        $orderCount = $orders->count();

        foreach ($orders as $order) {
            // OrderItems are removed automatically via the cascadeOnDelete
            // foreign key defined on the order_items migration.
            $order->delete();
        }

        // ---- Repairs ----
        $repairs = Repair::whereIn('status', ['completed', 'cancelled'])
            ->where('updated_at', '<', $cutoff)
            ->get();

        $repairCount = $repairs->count();

        foreach ($repairs as $repair) {
            // repair_status_histories and repair_deliveries are removed
            // automatically via their cascadeOnDelete foreign keys.
            $repair->delete();
        }

        $this->info("Deleted {$orderCount} old order(s) and {$repairCount} old repair(s).");
    }
}