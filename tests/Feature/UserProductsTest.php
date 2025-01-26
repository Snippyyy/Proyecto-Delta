<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('User can see the his publish products', function () {
    //Arrange
    $user = User::factory()->create();
    $product = Product::factory()->create([
        'status' => 'published',
        'seller_id' => $user->id
    ]);

    //Act
    actingAs($user);
    $response = get(route('my-products'));
    //Assert

    $response->assertSee($product->name);
    $response->assertSee($product->description);
});

it('User can see his pending products', function () {
    //Arrange
    $user = User::factory()->create();
    $product = Product::factory()->create([
        'status' => 'pending',
        'seller_id' => $user->id
    ]);

    //Act
    actingAs($user);
    $response = get(route('my-products'));
    //Assert

    $response->assertSee($product->name);
    $response->assertSee($product->description);
});

it('User can access to the products from his panel product page', function () {

    $user = User::factory()->create();
    $product = Product::factory()->create([
        'status' => 'published',
        'seller_id' => $user->id
    ]);

    actingAs($user);
    $response = get(route('my-products'));

    $response->assertSee($product->name);
    $response->assertSee($product->description);
    $response->assertSeeHtml('<a href="' . route('product.show', $product) . '" class="">');
});
