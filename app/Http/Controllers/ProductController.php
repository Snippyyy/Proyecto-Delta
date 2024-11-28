<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return view('product.product-index' , compact('products'));
    }
    public function create() {
        $categories = Category::all();
        return view('product.product-create', compact('categories'));
    }
    public function store(ProductRequest $request) {
        $product = new Product($request->validated());
        $product->seller_id = Auth::id();
        $product->status = 'published';
        $product->save();
        return redirect()->route('product.index')->with('status', 'Product created!');
    }
    public function show(Product $product) {
        return view('product.product-show', compact('product'));
    }
    public function edit(Product $product) {
        $categories = Category::all();
        return view('product.product-edit', compact('product', 'categories'));
    }
    public function update(ProductRequest $request, Product $product) {
        $product->update($request->validated());
        return redirect()->route('product.show', $product)->with('status', 'Product updated successfully');
    }
    public function destroy(Product $product) {
        $product->delete();
        return redirect()->route('product.index')->with('status', 'Product deleted successfully');
    }
}
