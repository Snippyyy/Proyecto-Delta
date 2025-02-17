<?php

namespace App\Http\Middleware\Api\V1;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsProductOwner
{
    public function handle(Request $request, Closure $next)
    {
        $product = $request->route('product');
        if ($product->seller_id != Auth::id()){
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
