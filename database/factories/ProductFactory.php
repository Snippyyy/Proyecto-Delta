<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'seller_id' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory()->create()->id,
            'shipment' => $this->faker->boolean(),
            'status' => 'published',
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            ProductImage::factory()->count(1)->create(['product_id' => $product->id]);
        });
    }
}
