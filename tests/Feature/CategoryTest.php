<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

beforeEach(function () {
    roleSeeder();
});

it('Delta page show all categories correctly', function () {

    $categories = Category::factory()->count(3)->create();

    get(route('index'))
        ->assertOk()
        ->assertSee($categories[0]->name)
        ->assertSee($categories[1]->name)
        ->assertSee($categories[2]->name);

});

it('Category admin page show details of the category', function () {

        $category = Category::factory()->create();
        $user = User::factory()->create()->assignRole('admin');

        actingAs($user);

        get(route('categories', $category))
            ->assertOk()
            ->assertSee($category->name)
            ->assertSee($category->description)
            ->assertSee($category->icon);
});

it('Category show page shows products from his own category', function () {

    $user = User::factory()->create();
    $category = Category::factory()->create();
    $productA = Product::factory()->state([
        'name' => 'Producto A',
        'seller_id' => $user->id,
        'category_id' => $category->id,
    ])->create();

    $productB = Product::factory()->state([
        'name' => 'Producto B',
        'seller_id' => $user->id,
        'category_id' => $category->id,
    ])->create();

    $productC = Product::factory()->state([
        'name' => 'Producto C',
        'seller_id' => $user->id,
        'category_id' => $category->id,
    ])->create();

    get(route('category.show', $category))
        ->assertOk()
        ->assertSee($productA->name)
        ->assertSee($productB->name)
        ->assertSee($productC->name);
});

it('Category create page shows the form to create a new category', function () {

    $user = User::factory()->create()->assignRole('admin');

    actingAs($user);

    get(route('category.create'))
        ->assertOk()
        ->assertSee('name')
        ->assertSee('description')
        ->assertSee('icon');

});

it('Category edit page shows the form to edit a existing category', function () {

    $user = User::factory()->create()->assignRole('admin');
    $category = Category::factory()->create();

    actingAs($user);

    get(route('category.edit', $category))
        ->assertOk()
        ->assertSee('name')
        ->assertSee('description')
        ->assertSee('icon');

});

it('User without admin role can not delete a category', function () {

    $user = User::factory()->create();

    $category = Category::factory()->create();

    actingAs($user);

    $response = $this->delete(route('category.destroy', $category));

    $response->assertRedirect(route('index'))
        ->assertSessionHas('error', 'Solo los administradores pueden ver y administrar categorias');

});

it('User with admin role can delete a Category', function () {

    $user = User::factory()->create()->assignRole('admin');
    $category = Category::factory()->create();

    actingAs($user);

    $response = $this->delete(route('category.destroy', $category))
        ->assertRedirect(route('categories'))
        ->assertSessionHas('status', 'Categoria eliminada');
});

it('User without admin role can not edit a Category', function () {

    $user = User::factory()->create();

    $category = Category::factory()->create();

    actingAs($user);

    $response = $this->patch(route('category.update', $category), [
        'name' => 'Category B',
        'description' => 'Description of category B',
        'icon' => UploadedFile::fake()->image('newicon.png'),
    ]);

    $response->assertRedirect(route('index'))
        ->assertSessionHas('error', 'Solo los administradores pueden ver y administrar categorias');

});

it('User with admin role can edit a Category', function () {

    Storage::fake('public');

    $user = User::factory()->create()->assignRole('admin');


    $category = Category::factory()->create();

    actingAs($user);

    $response = $this->patch(route('category.update', $category), [
        'name' => 'Category B',
        'description' => 'Description of category B',
        'icon' => UploadedFile::fake()->image('newicon.png'),
    ]);

    $response->assertRedirect(route('category.show', $category))
        ->assertSessionHas('status', 'Categoria Actualizada');

    $categoryUpdated = Category::first();

    get(route('categories', $categoryUpdated))
        ->assertSee('Category B')
        ->assertSee('Description of category B')
        ->assertSee($categoryUpdated->icon);
});

it('User with admin role can create a Category', function () {

    Storage::fake('public');

    $user = User::factory()->create()->assignRole('admin');

    actingAs($user);

    $response = $this->post(route('category.store'), [
        'name' => 'Category A',
        'description' => 'Description of category A',
        'icon' => UploadedFile::fake()->image('icon.png'),
    ]);

    $category = Category::first();

    $response->assertRedirect(route('categories'))
        ->assertSessionHas('status', 'Categoria creada');

    get(route('category.show', $category))
        ->assertSee('Category A');
});

it('User without admin role can not create a Category', function () {

    Storage::fake('public');

    $user = User::factory()->create();

    actingAs($user);

    $response = $this->post(route('category.store'), [
        'name' => 'Category A',
        'description' => 'Description of category A',
        'icon' => UploadedFile::fake()->image('icon.png'),
    ]);

    $response->assertRedirect(route('index'))
        ->assertSessionHas('error', 'Solo los administradores pueden ver y administrar categorias');
});
