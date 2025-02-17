<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;
use function Pest\Laravel\patch;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);


it('list all products', function () {

    $products = Product::factory()->count(3)->create();

    $response = get(route('api.welcome'));


    foreach ($products as $product) {
        $response->assertJsonFragment([
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'category_id' => $product->category->id,
        ]);
    }
});

it('allows authenticated user to create a product', function () {

    Storage::fake('public');

    $user = User::factory()->create();
    $category = Category::factory()->create();

    $response = actingAs($user)->post(route('api.product.store'), [
        'name' => 'Test Product',
        'price' => 10,
        'description' => 'Test Description',
        'category_id' => $category->id,
        'shipment' => true,
        'img_path' => [UploadedFile::fake()->image('test_image.jpg')],
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure(['message', 'product']);

    $this->assertDatabaseHas('products', [
        'name' => 'Test Product',
        'price' => 1000,
        'description' => 'Test Description',
        'category_id' => $category->id,
        'seller_id' => $user->id,
    ]);
});

it('allows authenticated user to update their own product', function () {
    Storage::fake('public');

    $user = User::factory()->has(Product::factory())->create();
    $product = $user->products->first();

    $response = actingAs($user)->patch(route('api.product.update', $product), [
        'name' => 'Updated Product',
        'price' => 20,
        'description' => 'Updated Description',
        'category_id' => $product->category_id,
        'shipment' => true,
        'img_path' => [UploadedFile::fake()->image('updated_image.jpg')],
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure(['message', 'product']);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => 'Updated Product',
        'price' => 2000,
        'description' => 'Updated Description',
    ]);
});

it('prevents authenticated user from updating a product they do not own', function () {
    $user = User::factory()->create();
    $user2 = User::factory()->has(Product::factory())->create();
    $product = $user2->products->first();

    $response = actingAs($user)->patch(route('api.product.update', $product), [
        'name' => 'Updated Product',
        'price' => 20,
        'description' => 'Updated Description',
        'category_id' => $product->category_id,
        'shipment' => true,
        'img_path' => [UploadedFile::fake()->image('updated_image.jpg')],
    ]);

    $response->assertStatus(401);
});

it('allows authenticated user to delete their own product', function () {
    $user = User::factory()->has(Product::factory())->create();
    $product = $user->products->first();

    $response = actingAs($user)->delete(route('api.product.delete', $product));

    $response->assertStatus(200)
        ->assertJson(['message' => 'Producto eliminado correctamente']);

    $this->assertDatabaseMissing('products', ['id' => $product->id]);
});

it('prevents authenticated user from deleting a product they do not own', function () {
    $user = User::factory()->create();
    $user2 = User::factory()->has(Product::factory())->create();
    $product = $user2->products->first();

    $response = actingAs($user)->delete(route('api.product.delete', $product));

    $response->assertStatus(401);
});

it('allows authenticated user to publish their own product', function () {
    $user = User::factory()->has(Product::factory(['status' => 'pending']))->create();
    $product = $user->products->first();

    $response = actingAs($user)->patch(route('api.product.post', $product));

    $response->assertStatus(200)
        ->assertJson(['message' => 'Producto publicado correctamente']);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'status' => 'published',
    ]);
});

it('prevents authenticated user from publishing a product they do not own', function () {
    $user = User::factory()->create();
    $user2 = User::factory()->has(Product::factory(['status' => 'pending']))->create();
    $product = $user2->products->first();

    $response = actingAs($user)->patch(route('api.product.post', $product));

    $response->assertStatus(401);
});

it('allows anyone to view a product', function () {
    $product = Product::factory()->create();

    $response = get(route('api.product.show', $product));

    $response->assertStatus(200)->assertJsonStructure(['data' => ['id', 'name', 'price', 'description', 'category', 'shipment']]);
});
