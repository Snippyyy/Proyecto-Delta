<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('Auth user can use the Product create form', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $category = Category::factory([
        'name' => 'Test',
    ])->create();

    $response = $this->actingAs($user)
        ->post('/products' , [
            'name' => 'Test Product',
            'price' => 10,
            'description' => 'Test Description',
            'category_id' => $category->id,
            'shipment' => true,
            'img_path' => [UploadedFile::fake()->image('test_image.jpg')],

        ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('product.show', $user->products->first()))
        ->assertSessionHas('status', 'Producto creado!');
});

it('Auth user can use the Product create form (with multiple images)', function () {

    Storage::fake('public');
    $user = User::factory()->create();
    $category = Category::factory([
        'name' => 'Test',
    ])->create();

    $response = $this->actingAs($user)
        ->post('/products' , [
            'name' => 'Test Product',
            'price' => 10,
            'description' => 'Test Description',
            'category_id' => $category->id,
            'shipment' => true,
            'img_path' => [
                UploadedFile::fake()->image('test_image.jpg'),
                UploadedFile::fake()->image('test_image2.jpg'),
                UploadedFile::fake()->image('test_image3.jpg'),
            ],

        ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('product.show', $user->products->first()))
        ->assertSessionHas('status', 'Producto creado!');
});

it('Products that arent published dont show in the index page', function () {

    $product = Product::factory([
        'status' => 'pending',
    ])->create();

    get(route('index'))
        ->assertOk()
        ->assertDontSee($product->name);
});

it('Guest user can not use the Product create form', function () {


    $category = Category::factory([
        'name' => 'Test',
    ])->create();

    $response = $this
        ->post('/products' , [
            'name' => 'Test Product',
            'price' => 10,
            'description' => 'Test Description',
            'category_id' => $category->id,
            'shipment' => true,
            'img_path' => [UploadedFile::fake()->image('test_image.jpg')],

        ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect('/login');
});

it('User can not access to the edit page from a product that doesnt own', function () {
    $user = User::factory()->create();
    $user2 = User::factory()->has(Product::factory())->create();

    actingAs($user);


    get(route('product.edit', $user2->products->first()))
        ->assertRedirect(route('product.show', $user2->products->first()))
        ->assertSessionHas('error', 'No puedes actuar sobre un articulo que no es tuyo');
});

it('User can not update a product that doesnt own', function () {
    $user = User::factory()->create();
    $user2 = User::factory()->has(Product::factory())->create();

    $response = $this->actingAs($user)
        ->patch('/products/' . $user2->products->first()->slug, [
            'name' => 'Test Product',
            'price' => 10,
            'description' => 'Test Description',
            'category_id' => Category::get()->random()->id,
            'shipment' => true,
            'img_path' => [UploadedFile::fake()->image('test_image.jpg')],
        ]);
    $response->assertRedirect('/products/' . $user2->products->first()->slug)
        ->assertSessionHas('error', 'No puedes actuar sobre un articulo que no es tuyo');
});

it('User can update his own product', function () {
    Storage::fake('public');
    $user = User::factory()->has(Product::factory())->create();

    $product = $user->products->first();

    $response = $this->actingAs($user)
        ->patch('/products/' . $product->slug, [
            'name' => 'Test Product',
            'price' => 10,
            'description' => 'Test Description',
            'category_id' => Category::get()->random()->id,
            'shipment' => true,
            'img_path' => [UploadedFile::fake()->image('test_image.jpg')],

        ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect('/products/' . $product->slug)
        ->assertSessionHas('status', 'Producto actualizado correctamente');
});

it('User can access to edit page from his own product', function () {
    $user = User::factory()->has(Product::factory())->create();

    actingAs($user);

    get(route('product.edit', $user->products->first()))
        ->assertOk();
});

it('User can delete his own product', function () {
    $user = User::factory()->has(Product::factory())->create();

    $product = $user->products->first();

    $response = $this->actingAs($user)
        ->delete('/products/' . $product->slug);

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('index'))
        ->assertSessionHas('status', 'El producto ha sido eliminado correctamente');
});

it('User can not delete a product that doesnt own', function () {
    $user = User::factory()->create();
    $user2 = User::factory()->has(Product::factory())->create();

    $response = $this->actingAs($user)
        ->delete('/products/' . $user2->products->first()->slug);

    $response->assertRedirect(route('product.show', $user2->products->first()->slug))
        ->assertSessionHas('error', 'No puedes actuar sobre un articulo que no es tuyo');
});

it('Guest can not edit products', function () {
    $user = User::factory()->has(Product::factory())->create();

    get(route('product.edit', $user->products->first()))
        ->assertRedirect('/login');
});

it('User can see the edit button in his product show', function () {

        $user = User::factory()->has(Product::factory())->create();

        actingAs($user);

        get(route('product.show', $user->products->first()))
            ->assertOk()
            ->assertSee('Editar');
});

it('User can not see the edit button in a product show that doesnt own', function () {

    $user = User::factory()->create();
    $user2 = User::factory()->has(Product::factory())->create();

    actingAs($user);

    get(route('product.show', $user2->products->first()))
        ->assertDontSee('Editar');
});

it('Guest can not see the edit button in any product', function () {

    $user = User::factory()->has(Product::factory([
        'status' => 'published',
    ]))->create();

    get(route('product.show', $user->products->first()))
        ->assertOk()
        ->assertDontSee('Editar');
});

it('Guest can not update products', function () {

    $user = User::factory()->has(Product::factory())->create();

    $response = $this->patch('/products/' . $user->products->first()->id, [
        'name' => 'Test Product',
        'price' => 10,
        'description' => 'Test Description',
        'category_id' => Category::get()->random()->id,
        'shipment' => true,
        'img_path' => [UploadedFile::fake()->image('test_image.jpg')],
    ]);

    $response->assertRedirect('/login');
});

it('Guest can not delete products', function () {

    $user = User::factory()->has(Product::factory())->create();

    $response = $this->delete('/products/' . $user->products->first()->id);

    $response->assertRedirect('/login');
});

it('Guest can not see delete button', function () {

    $user = User::factory()->has(Product::factory([
        'status' => 'published',
    ]))->create();

    get(route('product.show', $user->products->first()))
        ->assertOk()
        ->assertDontSee('Eliminar');
});

it('User can see delete button in his own product', function () {

        $user = User::factory()->has(Product::factory())->create();

        actingAs($user);

        get(route('product.show', $user->products->first()))
            ->assertOk()
            ->assertSee('Eliminar');
});

it('User can not see delete button in a product that doesnt own', function () {

    $user = User::factory()->create();
    $user2 = User::factory()->has(Product::factory([
        'status' => 'published',
    ]))->create();

    actingAs($user);

    get(route('product.show', $user2->products->first()))
        ->assertOk()
        ->assertDontSee('Eliminar');
});

it('Product show page shows product information that allows shipment', function () {
    //Arrange
    $product = Product::factory([
        'shipment' => true,
        'status' => 'published',
    ])->create();
    //Act
    get(route('product.show', $product))
        ->assertSee($product->name)
        ->assertSee(number_format($product->price / 100, 2, ',', '.'))
        ->assertSee($product->description)
        ->assertSee('Acepta envios');

    foreach ($product->productImages as $image) {
        get(route('product.show', $product))
            ->assertSee($image->img_path);
    }
    //Assert

});

it('Product show page shows product information that denies shipment', function () {
    //Arrange
    $product = Product::factory([
        'shipment' => false,
        'status' => 'published',
    ])->create();
    //Act
    get(route('product.show', $product))
        ->assertOk()
        ->assertSee($product->name)
        ->assertSee(number_format($product->price / 100, 2, ',', '.'))
        ->assertSee($product->description)
        ->assertSee('No acepta envios');

    foreach ($product->productImages as $image) {
        get(route('product.show', $product))
            ->assertOk()
            ->assertSee($image->img_path);
    }
    //Assert
});
