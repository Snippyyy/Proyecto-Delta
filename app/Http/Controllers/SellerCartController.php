<?php

namespace App\Http\Controllers;

class SellerCartController extends Controller
{
    public function __invoke()
    {
        $carts = auth()->user()->sellerCart;
        return view('cart.index', compact('carts'));
    }
}
