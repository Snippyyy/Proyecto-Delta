<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsResource;
use App\Models\Product;

class WelcomePageController extends Controller
{
    public function __invoke()
    {
        $products = Product::where('status', 'published')->orderBy('created_at', 'desc')->get();

        return ProductsResource::collection($products);
    }
}
