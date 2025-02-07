<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('redirects user to index with error message if product is pending', function () {
    $user = User::factory()->has(Product::factory([
        'status' => 'pending',
    ])->count(1))->create();

    $user2 = User::factory()->create();

    $product = $user->products->first();

    actingAs($user2);
        get(route('product.show', $product))
        ->assertRedirect(route('index'))
        ->assertSessionHas('error', 'Este producto está pendiente de aprobación');
});

it('allows seller to access their own pending product', function () {
    $user = User::factory()->has(Product::factory([
        'status' => 'pending',
    ])->count(1))->create();

    $product = $user->products->first();
    actingAs($user)
        ->get(route('product.show', $product))
        ->assertStatus(200);
});

it('allows user to access published product', function () {
    $user = User::factory()->has(Product::factory([
        'status' => 'published',
    ])->count(1))->create();

    $product = $user->products->first();

        get(route('product.show', $product))
        ->assertStatus(200);
});
