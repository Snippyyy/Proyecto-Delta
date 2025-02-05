<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CantPurchaseSoldItemsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $product = $request->route('product');

        if ($product->status == 'sold') {
            return redirect()->route('product.show', $product)->with('error', 'Este producto ya ha sido vendido');
        }
        return $next($request);
    }
}
