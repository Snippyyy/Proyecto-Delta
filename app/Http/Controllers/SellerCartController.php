<?php

namespace App\Http\Controllers;


use App\Models\DiscountCode;
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

    public function discount_apply(SellerCart $cart, Request $request)
    {
        $discount_code = DiscountCode::where('code', $request->discount)->first();

        if ($discount_code) {
            $cart->discount_code_id = $discount_code->id;
            $cart->discount_price = $cart->total_price - ($cart->total_price * $discount_code->percentage / 100);
            $cart->save();
            return redirect()->route('cart.show', $cart)->with('success', 'Codigo de descuento aplicado');
        } else {
            return redirect()->route('cart.show', $cart)->with('error', 'Codigo de descuento invalido');
        }
    }

    public function remove_discount(SellerCart $cart)
    {
        $cart->discount_code_id = null;
        $cart->discount_price = null;
        $cart->save();
        return redirect()->route('cart.show', $cart)->with('success', 'Codigo de descuento removido');
    }
}
