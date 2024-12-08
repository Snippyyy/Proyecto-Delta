<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImageFactory extends Factory
{
    protected $model = ProductImage::class;

    public function definition()
    {
        return [
            'product_id' => Product::latest()->first()->id ?? Product::factory()->create()->id,
            'img_path' => 'https://picsum.photos/640/480?random=' . rand(1, 1000),
            'order' => 0,
        ];
    }

    public function configure(){
        return $this->afterCreating(function (ProductImage $productImage){
           $lastOrder = ProductImage::where('product_id', $productImage->product_id)
           ->max('order') ?? 0;

           $productImage->order = $lastOrder + 1;

           $productImage->save();
        });
    }
}
