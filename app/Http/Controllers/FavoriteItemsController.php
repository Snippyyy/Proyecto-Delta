<?php

namespace App\Http\Controllers;

use App\Models\FavoriteProducts;

class FavoriteItemsController extends Controller
{
    public function __invoke()
    {
        $favoriteItems = FavoriteProducts::where('user_id', auth()->id())->get();

        return view('product.favorite-products', compact('favoriteItems'));
    }
}
