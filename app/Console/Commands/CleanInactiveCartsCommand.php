<?php

namespace App\Console\Commands;

use App\Models\SellerCart;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanInactiveCartsCommand extends Command
{
    protected $signature = 'cart:clean';

    protected $description = 'Eliminar carritos inactivos';

    public function handle(): void
    {
        $time = Carbon::now()->subDays(30);

        $sellerCartsDeleted = SellerCart::where('updated_at', '<', $time)->where('user_id', null)->delete();

        $this->info("Se eliminaron $sellerCartsDeleted carritos de usuarios no autenticados.");
    }
}
