<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class WelcomePageController extends Controller
{
    public function __invoke()
    {
        $products = Product::with('productImages')->get();
        $categories = Category::all();
        return view('delta', compact('products', 'categories'));
    }
}
