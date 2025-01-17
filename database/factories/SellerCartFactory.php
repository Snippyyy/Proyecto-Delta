<?php

namespace Database\Factories;

use App\Models\SellerCart;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SellerCartFactory extends Factory
{
    protected $model = SellerCart::class;

    public function definition(): array
    {
        return [
            'seller_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => User::factory(),
            'total_price' => 0,
            'quantity' => 0,
        ];
    }
}
