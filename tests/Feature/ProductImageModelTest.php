<?php

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('BelongsTo products', function () {

    $productImage = ProductImage::factory()->create();

    expect($productImage->product)->toBeInstanceOf(Product::class);
});
