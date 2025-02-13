<?php

namespace App\Observers;

use App\Mail\ProductIsDeletedAdviceMail;
use App\Mail\ProductIsSoldAdviceMail;
use App\Models\Product;
use App\Models\SellerCart;
use Illuminate\Support\Facades\Log;

class ProductModifiedObserver
{
    public function updated(Product $product): void
    {
        if ($product->status == 'sold'){
            $carts = SellerCart::whereHas('cart_items', function($query) use ($product) {
                $query->where('product_id', $product->id); //implementar un scope???
            })->get();
            foreach ($carts as $cart) {
                    \Mail::to($cart->user->email)->queue(new ProductIsSoldAdviceMail($product, $cart->user->name));
            }
        }
    }

    public function deleting(Product $product): void
    {
        $carts = SellerCart::whereHas('cart_items', function($query) use ($product) {
            $query->where('product_id', $product->id);
        })->get();

        foreach ($carts as $cart) {
                \Mail::to($cart->user->email)->queue(new ProductIsDeletedAdviceMail($product->name, $cart->user->name, $product->user->name));
        }
    }
}
