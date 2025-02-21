<?php

namespace App\Http\Middleware;

use App\Models\User;
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
        $profileName = User::find($profileId)->name;

        if (!auth()->check()) {
            return redirect()->route('users.show', $profileName)->with('error', __('Debes iniciar sesión para comentar y comprar un articulo del usuario para poder comentar'));
        }

        $orders = auth()->user()->orders()->where('seller_id', $profileId)->get();

        if(auth()->user()->id == $profileId){
            return redirect()->route('users.show', $profileName)->with('error', __('No puedes comentar tu propio perfil'));
        }

        if ($orders->isEmpty()) {
            return redirect()->route('users.show', $profileName)->with('error', __('Debes comprar un articulo del usuario para poder comentar'));
        }

        return $next($request);
    }
}
