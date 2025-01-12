<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\SellerCart;
use Illuminate\Http\Request;


class ItemsCartController extends Controller
{
    public function store(Product $product, Request $request)
    {
        //GUEST
        if (!auth()->check()) {

            $cart = SellerCart::where('token', $request->cookie('guest_cart_token'))->first();


            if (!$cart) {
                $cart = SellerCart::create([
                    'seller_id' => $product->seller_id,
                    'token' => $request->cookie('guest_cart_token'),
                    'quantity' => 0,
                ]);
            }

            if ($cart->cart_items()->where('product_id', $product->id)->first()) {
                return redirect(route('product.show', $product))->with('error', 'Este producto ya se encuentra en el carrito');
            }

            $cart->cart_items()->create([
                'product_id' => $product->id,
                'cart_id' => $cart->id,
            ]);
            $cart->quantity = $cart->cart_items()->count();
            $cartItems = $cart->cart_items;
            $cart->total_price = $cartItems->sum('product.price');
            $cart->save();

            return redirect(route('product.show', $product))->with('status', 'Producto añadido al carrito');
        }


        //USERS
        if ($product->seller_id == auth()->id()) {
            return redirect(route('product.show', $product))->with('error', 'No puedes añadir tus propios productos al carrito');
        }

        if (!auth()->user()->sellerCart()->where('seller_id', $product->seller_id)->first()) {
            auth()->user()->sellerCart()->create([
                    'user_id' => auth()->id(),
                    'seller_id' => $product->seller_id,
                    'quantity' => 0,
                ]
            );
        }

        $cart = auth()->user()->sellerCart()->where('seller_id', $product->seller_id)->first();

        if ($cart->cart_items()->where('product_id', $product->id)->first()) {
            return redirect(route('product.show', $product))->with('error', 'Este producto ya se encuentra en el carrito');
        }

        $cart->cart_items()->create([
            'product_id' => $product->id,
            'cart_id' => $cart->id,
        ]);
        $cart->quantity = $cart->cart_items()->count();
        $cartItems = $cart->cart_items;
        $cart->total_price = $cartItems->sum('product.price');
        $cart->save();

        return redirect(route('product.show', $product))->with('status', 'Producto añadido al carrito');
    }

    public function show(SellerCart $cart)
    {
        $cartItems = $cart->cart_items;
        return view('cart.show', compact('cart', 'cartItems'));
    }

    public function destroy(SellerCart $cart, CartItem $product)
    {

        $product->delete();


        if ($cart->cart_items()->count() == 0) {
            $product->sellerCart()->delete();
            return redirect(route('cart.index'))->with('status', 'Producto eliminado del carrito');
        }

        $cart = $product->sellerCart;
        $cart->quantity = $cart->count();
        $cartItems = $cart->cart_items;
        $cart->total_price = $cartItems->sum('product.price');
        $cart->save();
        return redirect(route('cart.show', $cart))->with('status', 'Producto eliminado del carrito');
    }
}
