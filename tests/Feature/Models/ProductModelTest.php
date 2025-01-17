<?php

use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('BelongsTo User', function () {
    $product = Product::factory()->create();
    expect($product->user)->toBeInstanceOf(User::class);
});

it('HasMany ProductImages', function () {

    $product = Product::factory()->has(ProductImage::factory()->count(3))->create();


    expect($product->productImages->count())
    ->toBeGreaterThan(3);

    expect($product->productImages->first())->toBeInstanceOf(ProductImage::class);

});


it('BelongsTo Category', function () {

    $category = Category::factory()->create();
    $product = Product::factory()->create();
    expect($product->category)->toBeInstanceOf(Category::class);

});

it('HasMany cart_items', function () {

    $user = User::factory()->has(Product::factory())->create();
    $product = $user->products->first();
    post(route('cart.store', $product))
        ->assertSessionHas('status', 'Producto añadido al carrito');

    expect($product->cart_items->count())->toBeGreaterThan(0);
    expect($product->cart_items->first())->toBeInstanceOf(CartItem::class);


});
