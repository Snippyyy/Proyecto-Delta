<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\DiscountCode;
use App\Models\Product;
use App\Policies\CategoryPolicy;
use App\Policies\DiscountCodePolicy;
use App\Policies\ProductPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Schedule $schedule): void
    {

        $schedule->command('cart:clean')->daily();
        $schedule->command('discounts:deactivate-expired')->daily();
    }
}
