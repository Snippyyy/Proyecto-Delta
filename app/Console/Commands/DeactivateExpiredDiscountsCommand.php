<?php

namespace App\Console\Commands;

use App\Models\DiscountCode;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeactivateExpiredDiscountsCommand extends Command
{
    protected $signature = 'discounts:deactivate-expired';
    protected $description = 'Desactiva los códigos de descuento expirados';

    public function handle()
    {
        $expiredCodes = DiscountCode::where('valid_until', '<', Carbon::now())
            ->where('is_active', true)
            ->update(['is_active' => false]);

        $this->info("Se desactivaron {$expiredCodes} códigos expirados.");
    }
}
