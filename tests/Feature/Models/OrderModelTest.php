<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('an order belongs to a buyer', function () {
    $buyer = User::factory()->create();
    $order = Order::factory()->create(['buyer_id' => $buyer->id]);

    expect($order->buyer_user)->toBeInstanceOf(User::class);
    expect($order->buyer_user->id)->toBe($buyer->id);
});

it('an order belongs to a seller', function () {
    $seller = User::factory()->create();
    $order = Order::factory()->create(['seller_id' => $seller->id]);

    expect($order->seller_user)->toBeInstanceOf(User::class);
    expect($order->seller_user->id)->toBe($seller->id);
});

it('an order has many order items', function () {
    $order = Order::factory()->create();
    $products = Product::factory()->count(3)->create();
    $orderItems = $products->map(function ($product) use ($order) {
        return OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $product->id,
        ]);
    });

    expect($order->orderItems)->toHaveCount(3);
    expect($order->orderItems->first())->toBeInstanceOf(OrderItem::class);
});
