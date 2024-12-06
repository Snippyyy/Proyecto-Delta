<?php

namespace App\Services;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductImageService
{
    /**
     * Devuelve una lista de provincias.
     *
     * @return array
     */
    public static function store($files, Product $product)
    {
        $imgcont = 1;
        foreach ($files as $file) {
            if ($file->isValid()) {
                $path = $file->store('ProductImages', 'public');
                $data = [
                    'product_id' => $product->id,
                    'img_path' => $path,
                    'order' => $imgcont
                ];
                ProductImage::create($data);
                $imgcont++;
            }
        }
    }

    public static function destroyAllImages(Product $product){
        $images_path = ProductImage::where('product_id',$product->id)->get()->pluck('img_path');

        foreach ($images_path as $path) {
            Storage::disk('public')->delete($path);
        }
    }
}
