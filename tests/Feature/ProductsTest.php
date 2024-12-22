<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('Product show page shows product information that allows shipment', function () {
    //Arrange
    $product = Product::factory([
        'shipment' => true,
    ])->create();
    //Act
    get(route('product.show', $product))
        ->assertOk()
        ->assertSee($product->name)
        ->assertSee($product->price)
        ->assertSee($product->description)
        ->assertSee('Acepta envios');

    foreach ($product->productImages as $image) {
        get(route('product.show', $product))
            ->assertOk()
            ->assertSee($image->img_path);
    }
    //Assert

});

it('Product show page shows product information that denies shipment', function () {
    //Arrange
    $product = Product::factory([
        'shipment' => false,
    ])->create();
    //Act
    get(route('product.show', $product))
        ->assertOk()
        ->assertSee($product->name)
        ->assertSee($product->price)
        ->assertSee($product->description)
        ->assertSee('No acepta envios');

    foreach ($product->productImages as $image) {
        get(route('product.show', $product))
            ->assertOk()
            ->assertSee($image->img_path);
    }
    //Assert
});
