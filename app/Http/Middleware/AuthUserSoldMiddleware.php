<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthUserSoldMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()){
            return redirect()->route('index')->with('error', 'No puedes ver este pedido');
        }
        if (auth()->user()->id !== $request->route('order')->seller_id) {
            return redirect()->route('index')->with('error', 'No puedes ver este pedido');
        }
        return $next($request);
    }
}
