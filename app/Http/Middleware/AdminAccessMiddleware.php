<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('index')->with('error', __('Solo los administradores pueden ver y administrar esta seccion'));
        }
        return $next($request);
    }
}
