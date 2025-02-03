<?php

namespace App\Http\Middleware;

use App\Models\Product;
use Closure;
use Illuminate\Http\Request;

class CheckSoldItemsInCartMiddleware
{
    public function handle(Request $request, Closure $next)
    {

        $cart = $request->route('cart');
        $products = Product::whereIn('id', $cart->cart_items->pluck('product_id'))->get();

        foreach ($products as $product) {
            if ($product->status === 'sold') {
                return redirect()->route('cart.show', $cart)->with('error', 'Tienes articulos que ya han sido vendidos en tu carrito, eliminalos para continuar');
            }
        }
        return $next($request);
    }
}
