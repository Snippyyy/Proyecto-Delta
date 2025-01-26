<?php

namespace App\Http\Controllers;

class UserProductsController extends Controller
{
    public function __invoke()
    {
        $productsPending = auth()->user()->products()->where('status', 'pending')->get();
        $productsPublished = auth()->user()->products()->where('status', 'published')->get();
        return view('profile.my-products', compact('productsPending', 'productsPublished'));
    }
}
