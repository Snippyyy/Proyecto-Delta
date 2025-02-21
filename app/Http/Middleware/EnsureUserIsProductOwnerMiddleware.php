<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsProductOwnerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $product = $request->route('product');
        if ($product->seller_id != Auth::id()){
            return redirect()->route('product.show', $product)->with('error', __('No puedes actuar sobre un articulo que no es tuyo'));
        }
        return $next($request);
    }
}
