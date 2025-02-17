<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\Api\V1\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductImageService;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function store(ProductRequest $request) {
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


        return response()->json([
            'message' => 'Producto creado correctamente',
            'product' => new ProductResource($product)
        ], 201);
    }
    public function show(Product $product) {
        return new ProductResource($product);
    }
    public function update(ProductUpdateRequest $request, Product $product) {
        $validated = $request->validated();

        if($request->hasFile('img_path')){
            $files = $request['img_path'];
            ProductImageService::update($product, $files);
        }

        $product->update($validated);
        $product->price = $validated['price'] * 100;
        $product->save();

        return response()->json([
            'message' => 'Producto actualizado correctamente',
            'product' => new ProductResource($product)
        ]);
    }
    public function destroy(Product $product) {
        if ($product->seller_id != Auth::id()){
            return redirect()->route('product.show', $product)->with('status', 'No puedes eliminar un articulo que no es tuyo');
        }

        $product->delete();
        return response()->json([
            'message' => 'Producto eliminado correctamente'
        ]);
    }

    public function post(Product $product) {

        if ($product->status == 'published') {
            return response()->json([
                'message' => 'El producto ya está publicado',
            ]);
        }

        $product->status = 'published';
        $product->save();
        return response()->json([
            'message' => 'Producto publicado correctamente',
            'product' => new ProductResource($product)
        ]);
    }
}
