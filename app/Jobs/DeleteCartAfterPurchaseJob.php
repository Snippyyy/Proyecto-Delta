<?php

namespace App\Jobs;

use App\Models\SellerCart;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteCartAfterPurchaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected SellerCart $cart;

    public function __construct(SellerCart $cart)
    {
        $this->cart = $cart;
    }

    public function handle(): void
    {

        $this->cart->delete();

    }
}
