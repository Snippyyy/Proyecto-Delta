<?php

namespace App\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(Schedule $schedule): void
    {
        $schedule->command('cart:clean')->dailyAt('03:00');
    }
}
