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
            'slug' => $this->faker->slug(),
            'description' => $this->faker->text(),
            'price' => $this->faker->numberBetween(1000, 100000),
            'seller_id' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory()->create()->id,
            'shipment' => $this->faker->boolean(),
            'status' => 'published',
        ];
    }

    public function configure()
    {

        return $this->afterCreating(function (Product $product) {
            ProductImage::factory()->create(['product_id' => $product->id]);
        });
    }
}
