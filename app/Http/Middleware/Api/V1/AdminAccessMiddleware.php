<?php

namespace App\Http\Middleware\Api\V1;

use Closure;
use Illuminate\Http\Request;

class AdminAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['message' => 'Solo los administradores pueden ver y administrar esta seccion'], 401);
        }
        return $next($request);
    }
}
