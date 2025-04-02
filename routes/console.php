<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

//define a command to process kitchen orders
app()->booted(function () {
    $schedule = app(Schedule::class);
    $schedule->command('app:process-kitchen-orders-command')->everyMinute();
});
