<?php

namespace App\Http\Middleware;

use App\Models\Product;
use Closure;
use Illuminate\Http\Request;

class PendingProductMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $product = $request->route('product');

        if ($product->seller_id == auth()->id()) {
            return $next($request);
        }

        if ($product->status == 'pending') {
            return redirect()->route('index')->with('error', 'Este producto está pendiente de aprobación');
        }
        return $next($request);
    }
}
