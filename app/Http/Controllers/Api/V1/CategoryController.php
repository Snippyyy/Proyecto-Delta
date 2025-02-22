<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryProductsResource;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    /**
     * @group Categorías
     *
     * Obtener todas las categorías
     *
     * Este endpoint recupera todas las categorías registradas.
     *
     * @response 200 {
     *  "data": [
     *    {
     *      "id": 1,
     *      "name": "Categoría 1",
     *      "icon": "path/to/icon.png",
     *      "created_at": "2023-01-01T00:00:00.000000Z",
     *      "updated_at": "2023-01-01T00:00:00.000000Z"
     *    }
     *  ]
     * }
     */
    public function index(){
        $categories = Category::all();
        return CategoryResource::collection($categories);
    }

    /**
     * @group Categorías
     *
     * Crear una nueva categoría
     *
     * Este endpoint permite crear una nueva categoría.
     *
     * @bodyParam name string required El nombre de la categoría. Ejemplo: "Categoría 1"
     * @bodyParam icon file El ícono de la categoría.
     *
     * @response 201 {
     *  "message": "Categoría creada"
     * }
     */
    public function store(CategoryRequest $request){
        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('icons', 'public');
            $validated = $request->validated();
            $validated['icon'] = $path;
            Category::create($validated);
            return response()->json(['message' => 'Categoría creada'], 201);
        } else {
            Category::create($request->validated());
            return response()->json(['message' => 'Categoría creada'], 201);
        }
    }

    /**
     * @group Categorías
     *
     * Obtener una categoría
     *
     * Este endpoint recupera una categoría específica por ID.
     *
     * @response 200 {
     *  "data": {
     *    "id": 1,
     *    "name": "Categoría 1",
     *    "icon": "path/to/icon.png",
     *    "created_at": "2023-01-01T00:00:00.000000Z",
     *    "updated_at": "2023-01-01T00:00:00.000000Z"
     *  }
     * }
     */
    public function show(Category $category){
        $products = Product::publishedWithCategory($category->id)->get();
        return CategoryProductsResource::collection($products, $category->name);
    }

    /**
     * @group Categorías
     *
     * Eliminar una categoría
     *
     * Este endpoint permite eliminar una categoría existente.
     *
     * @response 200 {
     *  "message": "Categoría eliminada"
     * }
     */
    public function destroy(Category $category){
        $category->delete();
        return response()->json(['message' => 'Categoría eliminada']);
    }

    /**
     * @group Categorías
     *
     * Actualizar una categoría
     *
     * Este endpoint permite actualizar una categoría existente.
     *
     * @bodyParam name string El nombre de la categoría. Ejemplo: "Categoría 1"
     * @bodyParam icon file El ícono de la categoría.
     *
     * @response 200 {
     *  "message": "Categoría actualizada"
     * }
     */
    public function update(CategoryRequest $request, Category $category){
        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('icons', 'public');
            $validated = $request->validated();
            $validated['icon'] = $path;
            $category->update($validated);
            return response()->json(['message' => 'Categoría actualizada']);
        } else {
            $category->update($request->validated());
            return response()->json(['message' => 'Categoría actualizada']);
        }
    }
}
