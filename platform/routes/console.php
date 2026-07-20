<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Shared hosting: run via cron -> php artisan schedule:run
Schedule::command('queue:work --stop-when-empty --max-time=55')->everyMinute();
Schedule::command('cache:prune-stale-tags')->hourly();
