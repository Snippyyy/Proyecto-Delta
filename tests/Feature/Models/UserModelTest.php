<?php

use App\Models\Product;
use App\Models\SellerCart;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('HasMany Products', function () {

    $user = User::factory()->has(Product::factory())->create();

    expect($user->products->first())->toBeInstanceOf(Product::class);

});

it('HasMany SellerCart', function () {

    $user = User::factory()->has(SellerCart::factory())->create();

    expect($user->sellerCarts->first())->toBeInstanceOf(SellerCart::class);
});
