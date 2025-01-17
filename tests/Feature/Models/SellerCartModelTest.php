<?php

use App\Models\CartItem;
use App\Models\SellerCart;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('BelongsTo user', function () {

    $sellerCart = SellerCart::factory()->create();

    expect($sellerCart->user)->toBeInstanceOf(User::class);

});

it('HasMany CartItems', function () {

    $sellerCart = SellerCart::factory()->has(CartItem::factory()->count(3), 'cart_items')->create();

    expect($sellerCart->cart_items)->toHaveCount(3);

    expect($sellerCart->cart_items->first())->toBeInstanceOf(CartItem::class);

});

it('BelongsTo seller user', function () {

    $sellerCart = SellerCart::factory()->create();

    expect($sellerCart->seller)->toBeInstanceOf(User::class);
});
