<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::factory()->count(10)->has(ProductImage::factory()->count(3))->create();
    }
}
