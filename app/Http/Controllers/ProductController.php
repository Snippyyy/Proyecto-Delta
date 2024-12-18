<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\ProductImageService;
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

        $validated = $request->validated();
        $product = new Product($validated);
        $product->seller_id = Auth::id();
        $product->status = 'published';
        $product->save();
        if($request->hasFile('img_path')){
            $files = $request['img_path'];
            ProductImageService::store($files, $product);
        }

        return redirect()->route('product.index')->with('status', 'Product created!');
    }
    public function show(Product $product) {
        return view('product.product-show', compact('product'));
    }
    public function edit(Product $product) {
        $categories = Category::all();
        return view('product.product-edit', compact('product', 'categories'));
    }
    public function update(ProductUpdateRequest $request, Product $product) {

        $validated = $request->validated();


        if($validated['image_delete_confirmation'] ?? false){
            if ($validated['images_to_delete'] ?? false){
            ProductImageService::destroy($validated['images_to_delete']);
            }
        }
        if($request->hasFile('img_path')){
            $files = $request['img_path'];
            ProductImageService::update($product, $files);
        }


        $product->update($validated);
        return redirect()->route('product.show', $product)->with('status', 'Product updated successfully');
    }
    public function destroy(Product $product) {
        ProductImageService::destroyAllImages($product);
        $product->delete();
        return redirect()->route('product.index')->with('status', 'Product deleted successfully');
    }
}
