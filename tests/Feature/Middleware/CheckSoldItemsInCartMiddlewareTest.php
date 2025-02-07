<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('redirects user to cart with error message if cart contains sold items trying to purchase', function () {
    $user = User::factory()->has(Product::factory(['status' => 'published'])->count(1))->create();
    $user2 = User::factory()->create();

    $product = $user->products->first();

    actingAs($user2);

    post(route('cart.store', $product))
        ->assertRedirect(route('product.show', $product))
        ->assertSessionHas('status', 'Producto añadido al carrito');

    $product->status = 'sold';
    $product->save();

    post(route('cart.checkout', $user2->sellerCarts->first()))
        ->assertRedirect(route('cart.show', $user2->sellerCarts->first()))
        ->assertSessionHas('error', 'Tienes articulos que ya han sido vendidos en tu carrito, eliminalos para continuar');
});

