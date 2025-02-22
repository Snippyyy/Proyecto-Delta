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
        ];
    }
}
