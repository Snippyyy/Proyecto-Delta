<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CommentsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $id
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $profileId = $request->route('user');

        $orders = auth()->user()->orders()->where('seller_id', $profileId)->get();


        if (!auth()->check()) {
            return redirect()->back()->with('error', 'Debes iniciar sesión para comentar y comprar un articulo del usuario para poder comentar');
        }

        if(auth()->user()->id == $profileId){
            return redirect()->back()->with('error', 'No puedes comentar tu propio perfil');
        }

        if ($orders->isEmpty()) {
            return redirect()->back()->with('error', 'Debes comprar un articulo del usuario para poder comentar');
        }

        return $next($request);
    }
}
