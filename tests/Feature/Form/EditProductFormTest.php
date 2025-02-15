<?php

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);


beforeEach(function () {
    Artisan::call('migrate:fresh'); //CAMBIAR
});

function loguedUserWithProduct(): void
{
    $user = User::factory()->has(Product::factory())->create();
    actingAs($user);
}

it('name field is required', function () {

    $user = User::factory()->has(Product::factory())->create();
    actingAs($user);

    $response = $this->patch('/products/1', [
        'name' => '',
        'description' => 'description',
        'price' => '10',
        'shipment' => true,
        'category_id' => '1',
    ]);
    $response->assertSessionHasErrors('name');
});

it('description field is required', function () {

    loguedUserWithProduct();

    $response = $this->patch('/products/1', [
        'name' => 'Product Name',
        'description' => '',
        'price' => '10',
        'shipment' => true,
        'category_id' => '1',
    ]);

    $response->assertSessionHasErrors('description');
});

it('price field is required', function () {

    loguedUserWithProduct();

    $response = $this->patch('/products/1', [
        'name' => 'Product Name',
        'description' => 'description',
        'price' => '',
        'shipment' => true,
        'category_id' => '1',
    ]);

    $response->assertSessionHasErrors('price');

});

it('category field should be one that exists', function () {

    loguedUserWithProduct();

    $response = $this->patch('/products/1', [
        'name' => 'Product Name',
        'description' => 'description',
        'price' => '10',
        'shipment' => true,
        'category_id' => '2',
    ]);

    $response->assertSessionHasErrors('category_id');
});

it('images to delete must exist', function () {

    $user = User::factory()->has(Product::factory()->has(ProductImage::factory()->count(3)))->create();
    $product = $user->products->first();

    actingAs($user);

    $response = $this->patch('/products/' . $product->id, [
        'name' => 'Product Name',
        'description' => 'description',
        'price' => '10',
        'shipment' => true,
        'category_id' => '1',
        'image_delete_confirmation' => true,
        'images_to_delete' => [999],
    ]);

    $response->assertSessionHasErrors('images_to_delete.0');
});

it('Image delete field works', function () {

    $user = User::factory()->has(Product::factory()->has(ProductImage::factory()->count(3)))->create();
    $product = $user->products->first();
    $existingImageId = $product->productImages->first()->id;

    $response = $this->patch('/products/' . $product->id, [
        'name' => 'Product Name',
        'description' => 'description',
        'price' => '10',
        'shipment' => true,
        'category_id' => '1',
        'image_delete_confirmation' => true,
        'images_to_delete' => [$existingImageId],
    ]);

    $response->assertSessionHasNoErrors();
});

it('User can not eliminate all images from a product, must be at least one', function () {

        $user = User::factory()->has(Product::factory())->create();
        $product = $user->products->first();
        $existingImageId = $product->productImages->first()->id;

        actingAs($user);

        $response = $this->patch('/products/' . $product->id, [
            'name' => 'Product Name',
            'description' => 'description',
            'price' => '10',
            'shipment' => true,
            'category_id' => '1',
            'image_delete_confirmation' => true,
            'images_to_delete' => [$existingImageId],
        ]);

        $response->assertRedirect(route('product.edit', $product))
            ->assertSessionHas('error', 'No puedes eliminar todas las imagenes del producto');
});

it('can upload a image', function () {

    Storage::fake('public');

    $user = User::factory()->has(Product::factory())->create();
    $product = $user->products->first();

    actingAs($user);

    $response = $this->patch('/products/' . $product->id, [
        'name' => 'Product Name',
        'description' => 'description',
        'price' => '10',
        'shipment' => true,
        'category_id' => '1',
        'img_path' => [UploadedFile::fake()->image('test_image.jpg')],
    ]);

    $response->assertRedirect(route('product.show', $product))
        ->assertSessionHas('status', 'Producto actualizado correctamente')
        ->assertSessionHasNoErrors();

});

