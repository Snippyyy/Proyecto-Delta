<?php

namespace App\Listeners;

use App\Events\OrderPaidEvent;
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
            Mail::to($order->buyer_user->email)->queue(new SuccessfulPurchaseMail($order));

            //LOGICA PARA cambiar estados de los productos y borrar el carrito comprado

            $cart = SellerCart::where('seller_id', $order->seller_id)->where('user_id', auth()->id())->first();
            $CartItems = CartItem::where('seller_cart_id', $cart->id)->get();
            $products = Product::whereIn('id', $CartItems->pluck('product_id'))->get();

            $cart->delete();
            foreach ($products as $product) {
                $product->status = 'sold';
                $product->save();
            }
        }
    }
}
