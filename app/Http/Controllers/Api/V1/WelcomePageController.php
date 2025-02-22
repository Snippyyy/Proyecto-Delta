<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsResource;
use App\Models\Product;

class WelcomePageController extends Controller
{
    /**
     * @group Productos
     *
     * Obtener productos publicados
     *
     * Este endpoint recupera todos los productos publicados ordenados por fecha de creación.
     *
     * @response 200 {
     *  "data": [
     *    {
     *      "id": 1,
     *      "name": "Producto 1",
     *      "description": "Descripción del producto 1",
     *      "price": 1000,
     *      "status": "published",
     *      "created_at": "2023-01-01T00:00:00.000000Z",
     *      "updated_at": "2023-01-01T00:00:00.000000Z"
     *    }
     *  ]
     * }
     */
    public function __invoke()
    {
        $products = Product::where('status', 'published')->orderBy('created_at', 'desc')->get();

        return ProductsResource::collection($products);
    }
}
