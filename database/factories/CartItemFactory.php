<?php

namespace Database\Factories;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\SellerCart;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{
    protected $model = CartItem::class;

    public function definition(): array
    {
        return [
            'seller_cart_id' => SellerCart::inRandomOrder()->first()->id ?? SellerCart::factory()->create()->id,
            'product_id' => Product::inRandomOrder()->first()->id ?? Product::factory()->create()->id,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (CartItem $cartItem) {
            $cartItem->sellerCart->total_price += $cartItem->product->price;
            $cartItem->sellerCart->quantity += 1;
            $cartItem->sellerCart->save();
        });
    }
}
