<?php

use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\SellerCart;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('BelongsTo products', function () {

    $CartItem = CartItem::factory()->create();

    expect($CartItem->product)->toBeInstanceOf(Product::class);
});

it('BelongsTo Seller Cart', function () {

    $CartItem = CartItem::factory()->create();

    expect($CartItem->sellerCart)->toBeInstanceOf(SellerCart::class);

});
