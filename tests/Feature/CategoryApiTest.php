<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\artisan;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\patch;
use function Pest\Laravel\delete;

uses(RefreshDatabase::class);

beforeEach(function () {
    artisan('db:seed --class=RoleSetterSeeder');
    $user = User::factory()->create();
    $user->assignRole('admin');
    $this->actingAs($user);
});

it('lists all categories', function () {
    Category::factory()->count(3)->create();

    $response = get(route('api.categories.index'));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'products_count'
                ]
            ]
        ]);
});

it('creates a category', function () {
    Storage::fake('public');

    $response = post(route('api.categories.store'), [
        'name' => 'Test Category',
        'description' => 'Test Description',
        'icon' => UploadedFile::fake()->image('icon.jpg')
    ]);

    $response->assertStatus(200)
        ->assertJson(['message' => 'Categoria creada']);

    $this->assertDatabaseHas('categories', [
        'name' => 'Test Category',
        'description' => 'Test Description',
    ]);
});

it('shows a category with products', function () {
    $category = Category::factory()->create();
    $products = Product::factory()->count(3)->create(['category_id' => $category->id]);

    $response = get(route('api.category.show', $category));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'category',
                    'id',
                    'name'
                ]
            ]
        ]);
});

it('updates a category', function () {
    Storage::fake('public');

    $category = Category::factory()->create();

    $response = patch(route('api.categories.update', $category), [
        'name' => 'Updated Category',
        'description' => 'Updated Description',
        'icon' => UploadedFile::fake()->image('updated_icon.jpg')
    ]);

    $response->assertStatus(200)
        ->assertJson(['message' => 'Categoria Actualizada']);

    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => 'Updated Category',
        'description' => 'Updated Description',
    ]);
});

it('deletes a category', function () {
    $category = Category::factory()->create();

    $response = delete(route('api.categories.delete', $category));

    $response->assertStatus(200)
        ->assertJson(['message' => 'Categoria eliminada']);

    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
});
