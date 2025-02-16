<?php

namespace App\Listeners;

use App\Events\OrderPaidEvent;
use App\Jobs\ChangeToSoldStatusProductJob;
use App\Jobs\DeleteCartAfterPurchaseJob;
use App\Mail\SuccessfulPurchaseMail;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\SellerCart;
use Illuminate\Support\Facades\Mail;

class OrderPaidListener
{
    public function __construct()
    {
    }

    public function handle(OrderPaidEvent $event): void
    {
        $order = $event->order;
        if ($order->status === 'paid') {
            Mail::to($order->buyer_user->email)->queue((new SuccessfulPurchaseMail($order))->onQueue('emails'));


            $cart = SellerCart::where(['seller_id' => $order->seller_id, 'user_id' => auth()->id()])->first();
            $products = Product::whereIn('id', CartItem::where('seller_cart_id', $cart->id)->pluck('product_id'))->get();

            //Logica pasada a un job -> DeleteCartAfterPurchaseJob
            DeleteCartAfterPurchaseJob::dispatch($cart);
            foreach ($products as $product) {
            ChangeToSoldStatusProductJob::dispatch($product);
            }
        }
    }
}
