<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryProductsResource;
use App\Models\Category;
use App\Models\Product;

class CategoryShowController extends Controller
{
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
    public function __invoke(Category $category)
    {
        $products = Product::publishedWithCategory($category->id)->get();
        return CategoryProductsResource::collection($products, $category->name);
    }
}
