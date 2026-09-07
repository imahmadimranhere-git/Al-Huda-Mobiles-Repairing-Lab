<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['title' => 'Motherboard Repair', 'description' => 'Component-level diagnostics and micro-soldering for faults that a screen or battery swap won\'t fix.', 'icon' => 'bi-cpu', 'display_order' => 1],
            ['title' => 'Screen & Battery', 'description' => 'Genuine and high-grade replacement parts, fitted and tested before your device leaves the bench.', 'icon' => 'bi-phone', 'display_order' => 2],
            ['title' => 'Live Tracking', 'description' => 'Every repair gets a tracking ID, so you always know exactly where your device is.', 'icon' => 'bi-qr-code-scan', 'display_order' => 3],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(['title' => $service['title']], $service);
        }
    }
}