<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\DeleteOldOrders;
use Illuminate\Support\Facades\Schedule;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


// Run daily at 1 AM — deletes completed/cancelled orders older than 1 month
Schedule::command(DeleteOldOrders::class)->dailyAt('01:00');