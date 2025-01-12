<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class EnsureGuestHasCartTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            return $next($request);
        }

        if (!$request->hasCookie('guest_cart_token')) {
            $guestToken = (string) Str::uuid();
            Cookie::queue('guest_cart_token', $guestToken, 60 * 24 * 30); // 30 días
        }

        return $next($request);
    }
}
