<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('Data user is displayed in user show view', function () {
    $user = User::factory()->has(Product::factory()->count(3))->create();

    $response = get(route('users.show', $user->name));

        $response
        ->assertOk()
        ->assertSee($user->name)
        ->assertSee($user->province)
        ->assertSee($user->postal_code)
        ->assertSee($user->phone_number)
        ->assertSee($user->email);
});

it('User product is displayed in user show view', function () {
    $user = User::factory()->has(Product::factory()->count(3))->create();

    $response =get(route('users.show', $user->name));

    foreach ($user->products as $product) {
        $response
            ->assertSee($product->name)
            ->assertSee(number_format($product->price / 100, 2, ',', '.'));
    }
});
