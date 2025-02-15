<?php

namespace Database\Factories;

use App\Models\FavoriteProducts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Product;

class FavoriteItemsFactory extends Factory
{
    protected $model = FavoriteProducts::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'note' => $this->faker->sentence,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
