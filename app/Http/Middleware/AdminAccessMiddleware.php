<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesion para ver categorias');
        }
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('index')->with('error', 'Solo los administradores pueden ver y administrar categorias');
        }
        return $next($request);
    }
}
