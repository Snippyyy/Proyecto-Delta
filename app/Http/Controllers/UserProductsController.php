<?php

namespace App\Http\Controllers;

class UserProductsController extends Controller
{
    public function __invoke()
    {
        $productsPending = auth()->user()->products()->pending()->get();
        $productsPublished = auth()->user()->products()->published()->get();
        return view('profile.my-products', compact('productsPending', 'productsPublished'));
    }
}
