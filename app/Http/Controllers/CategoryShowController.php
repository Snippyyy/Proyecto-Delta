<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class CategoryShowController extends Controller
{
    public function __invoke(Category $category)
    {
        $categories = Category::all();
        $products = Product::publishedWithCategory($category->id)->get();
        return view('category.show', compact('category','products', 'categories'));
    }
}
