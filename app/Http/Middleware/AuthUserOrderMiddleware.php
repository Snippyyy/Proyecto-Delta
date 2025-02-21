<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthUserOrderMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()){
            return redirect()->route('index')->with('error', __('No puedes ver este pedido'));
        }
        if (auth()->user()->id !== $request->route('order')->buyer_id) {
            return redirect()->route('index')->with('error', __('No puedes ver este pedido'));
        }
        return $next($request);
    }
}
