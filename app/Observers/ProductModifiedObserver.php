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
                $query->where('product_id', $product->id);
            })->get();
            foreach ($carts as $cart) {
                if ($cart->user) {
                    \Mail::to($cart->user->email)->queue((new ProductIsSoldAdviceMail($product, $cart->user->name))->onQueue('emails'));
                }
            }
        }
    }

    public function deleting(Product $product): void
    {
        //Eliminacion de imagenes sin hacer uso del ImageService Creado en los comienzos del proyecto
        foreach ($product->productImages as $image) {
            \Storage::disk('public')->delete($image->img_path);
        }

        $carts = SellerCart::whereHas('cart_items', function($query) use ($product) {
            $query->where('product_id', $product->id);
        })->get();

        foreach ($carts as $cart) {
            if ($cart->user) {
                \Mail::to($cart->user->email)->queue((new ProductIsDeletedAdviceMail($product->name, $cart->user->name, $product->user->name))->onQueue('emails'));
            }
        }
    }
}
