<?php

namespace App\Services;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductImageService
{
    /**
     * Gestion de Imagenes de productos
     *
     * @return array
     */
    public static function store($files, Product $product)
    {
        $imgcont = 1; //Quitar logica de conteo del cuenteo de imagenes
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

    public static function update(Product $product, $files){

        foreach ($files as $file) {
            if ($file->isValid()) {
                $path = $file->store('ProductImages', 'public');
                $data = [
                    'product_id' => $product->id,
                    'img_path' => $path,
                ];
                ProductImage::create($data);
            }
        }
    }


    public static function destroy($images_to_delete){



        foreach ($images_to_delete as $image) {
            $img_path = ProductImage::where('id', $image)->get()->value('img_path');
            ProductImage::destroy($image);

            Storage::disk('public')->delete($img_path);
        }
    }


    public static function destroyAllImages(Product $product){
        $images_path = ProductImage::where('product_id',$product->id)->get()->pluck('img_path');

        foreach ($images_path as $path) {
            Storage::disk('public')->delete($path);
        }
    }

}
