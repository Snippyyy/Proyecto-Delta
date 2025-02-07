<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\User;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

it('User cant add to cart a item that has been sold', function () {
    $user = User::factory()->has(Product::factory([
        'status' => 'sold',
    ])->count(1))->create();

    $user2 = User::factory()->create();

    $product = $user->products->first();


    actingAs($user2)
        ->post(route('cart.store', $product))
        ->assertRedirect(route('product.show', $product))
        ->assertSessionHas('error', 'Este producto ya ha sido vendido');
});

