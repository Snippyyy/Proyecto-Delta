<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductImageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;
    public function create() {
        $this->authorize('create', Product::class);
        $categories = Category::all();
        return view('product.product-create', compact('categories'));
    }
    public function store(ProductRequest $request) {
        $this->authorize('create', Product::class);
        $validated = $request->validated();
        $product = new Product($validated);
        $product->price = $validated['price'] * 100;
        $product->seller_id = Auth::id();
        $product->status = 'published';

        if ($validated['pending'] == 1) {
            $product->status = 'pending';
        }

        $product->save();
        if($request->hasFile('img_path')){
            $files = $request['img_path'];
            ProductImageService::store($files, $product);
        }


        return redirect()->route('product.show', $product)->with('status', __('Producto creado!'));
    }
    public function show(Product $product) {

        return view('product.product-show', compact('product'));
    }
    public function edit(Product $product) {
        $this->authorize('update', $product);
        $categories = Category::all();
        return view('product.product-edit', compact('product', 'categories'));
    }
    public function update(ProductUpdateRequest $request, Product $product) {
        $this->authorize('update', $product);

        $validated = $request->validated();

        if($validated['image_delete_confirmation'] ?? false){
            if ($validated['images_to_delete'] ?? false){
                if (count($validated['images_to_delete']) == $product->productImages->count()){
                        return redirect()->route('product.edit', $product)->with('error', __('No puedes eliminar todas las imagenes del producto'));
                }
            ProductImageService::destroy($validated['images_to_delete']);
            }
        }
        if($request->hasFile('img_path')){
            $files = $request['img_path'];
            ProductImageService::update($product, $files);
        }

        $product->update($validated);
        $product->price = $validated['price'] * 100;
        $product->save();

        return redirect()->route('product.show', $product)->with('status', __('Producto actualizado correctamente'));
    }
    public function destroy(Product $product) {
        $this->authorize('delete', $product);

        $product->delete();
        return redirect()->route('index')->with('status', __('El producto ha sido eliminado correctamente'));
    }

    public function post(Product $product) {
        $this->authorize('update', $product);
        $product->status = 'published';
        $product->save();
        return redirect()->route('product.show', $product)->with('status', __('Producto publicado correctamente'));
    }
}
