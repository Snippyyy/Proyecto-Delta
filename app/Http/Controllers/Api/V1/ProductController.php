<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\Api\V1\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductImageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    /**
     * @group Productos
     *
     * Crear un nuevo producto
     *
     * Este endpoint permite crear un nuevo producto.
     *
     * @bodyParam name string required El nombre del producto. Ejemplo: "Producto 1"
     * @bodyParam description string required La descripción del producto. Ejemplo: "Descripción del producto 1"
     * @bodyParam price float required El precio del producto. Ejemplo: 10.00
     * @bodyParam img_path file[] Las imágenes del producto.
     * @bodyParam pending boolean Indica si el producto está pendiente de revisión. Ejemplo: false
     *
     * @response 201 {
     *  "message": "Producto creado correctamente",
     *  "product": {
     *    "id": 1,
     *    "name": "Producto 1",
     *    "description": "Descripción del producto 1",
     *    "price": 1000,
     *    "status": "published",
     *    "created_at": "2023-01-01T00:00:00.000000Z",
     *    "updated_at": "2023-01-01T00:00:00.000000Z"
     *  }
     * }
     */
    public function store(ProductRequest $request) {
        $validated = $request->validated();
        $product = new Product($validated);
        $product->price = $validated['price'] * 100;
        $product->seller_id = Auth::id();
        $product->status = 'published';
        $product->slug = $this->generateUniqueSlug($validated['name']);

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

    /**
     * @group Productos
     *
     * Obtener un producto
     *
     * Este endpoint recupera un producto específico por ID.
     *
     *
     * @response 200 {
     *  "data": {
     *    "id": 1,
     *    "name": "Producto 1",
     *    "description": "Descripción del producto 1",
     *    "price": 1000,
     *    "status": "published",
     *    "created_at": "2023-01-01T00:00:00.000000Z",
     *    "updated_at": "2023-01-01T00:00:00.000000Z"
     *  }
     * }
     */
    public function show(Product $product) {
        return new ProductResource($product);
    }

    /**
     * @group Productos
     *
     * Actualizar un producto
     *
     * Este endpoint permite actualizar un producto existente.
     *
     * @bodyParam name string El nombre del producto. Ejemplo: "Producto 1"
     * @bodyParam description string La descripción del producto. Ejemplo: "Descripción del producto 1"
     * @bodyParam price float El precio del producto. Ejemplo: 10.00
     * @bodyParam img_path file[] Las imágenes del producto.
     *
     * @response 200 {
     *  "message": "Producto actualizado correctamente",
     *  "product": {
     *    "id": 1,
     *    "name": "Producto 1",
     *    "description": "Descripción del producto 1",
     *    "price": 1000,
     *    "status": "published",
     *    "created_at": "2023-01-01T00:00:00.000000Z",
     *    "updated_at": "2023-01-01T00:00:00.000000Z"
     *  }
     * }
     */
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

    /**
     * @group Productos
     *
     * Eliminar un producto
     *
     * Este endpoint permite eliminar un producto existente.
     *
     *
     * @response 200 {
     *  "message": "Producto eliminado correctamente"
     * }
     */
    public function destroy(Product $product) {
        if ($product->seller_id != Auth::id()){
            return redirect()->route('product.show', $product)->with('status', 'No puedes eliminar un articulo que no es tuyo');
        }

        $product->delete();
        return response()->json([
            'message' => 'Producto eliminado correctamente'
        ]);
    }

    /**
     * @group Productos
     *
     * Publicar un producto
     *
     * Este endpoint permite cambiar el estado de un producto a publicado.
     *
     *
     * @response 200 {
     *  "message": "Producto publicado correctamente",
     *  "product": {
     *    "id": 1,
     *    "name": "Producto 1",
     *    "description": "Descripción del producto 1",
     *    "price": 1000,
     *    "status": "published",
     *    "created_at": "2023-01-01T00:00:00.000000Z",
     *    "updated_at": "2023-01-01T00:00:00.000000Z"
     *  }
     * }
     */

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

    private function generateUniqueSlug(string $name): string {
        $slug = Str::slug($name);
        $count = Product::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }
        return $slug;
    }
}
