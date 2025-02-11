<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureDiscountCodeIsActiveMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->route('cart')->discount_code && !$request->route('cart')->discount_code->is_active) {
            $cart = $request->route('cart');
            $cart->discount_code_id = null;
            $cart->discount_price = null;
            $cart->save();
            return redirect()->route('cart.show', $request->route('cart'))->with('error', 'El codigo de descuento se ha deshabilitado porque ya no esta disponible');
        }
        return $next($request);
    }
}
