<?php

namespace App\Http\Controllers;


use App\Models\SellerCart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SellerCartController extends Controller
{
    public function index (Request $request)
    {
        if (auth()->check()){
            $carts = auth()->user()->sellerCarts()->get();

            foreach ($carts as $cart) {
                if ($cart->cart_items()->count() == 0) {
                    $cart->delete();
                }
            }
            $carts = auth()->user()->sellerCarts;
            return view('cart.index', compact('carts'));
        }else{
            $carts = SellerCart::where('token', $request->cookie('guest_cart_token'))->get();

            foreach ($carts as $cart) {
                if ($cart->cart_items()->count() == 0) {
                    $cart->delete();
                }
            }
            $carts = SellerCart::where('token', $request->cookie('guest_cart_token'))->get();
            return view('cart.index', compact('carts'));
        }
    }
}
