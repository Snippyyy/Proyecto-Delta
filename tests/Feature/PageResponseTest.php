<?php

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\artisan;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

beforeEach(function () {
    roleSeeder();
});

it('First page response', function () {

    get(route('welcome'))->assertOk();

});

it('Login page response', function () {

    get(route('login'))->assertOk();

});

it('Register page response', function () {
    get(route('register'))->assertOk();
});

it('Guest cannot access Dashboard', function () {
    get(route('dashboard'))->assertRedirect('login');
});

it('Auth user can access to Dashboard', function() {

    $user = User::factory()->create();

    actingAs($user);

    get(route('dashboard'))->assertOk();
});

it('Delta page response', function () {
    get(route('index'))->assertOk();
});

it('Guest cannot access to product create route', function () {
    get(route('product.create'))->assertRedirect('login');
});
it('Auth user can access to product create route', function () {

    $user = User::factory()->create();

    actingAs($user);
    get(route('product.create'))->assertOk();
});

it('Product show page response', function () {

    $product = Product::factory([
        'status' => 'published'
    ])->create();

    get(route('product.show', $product))->assertOk();
});

it('Category admin page response', function () {
    actingAs(User::factory(
    )->create()->assignRole('admin'));
    get(route('categories'))->assertOk();
});

it('Category show page response', function () {
    $category = Category::factory()->create();
    get(route('category.show', $category))->assertOk();
});

it('User with admin role can access to edit Category form page', function () {

    $user = User::factory(
    )->create()->assignRole('admin');

    $category = Category::factory()->create();

    actingAs($user);

    get(route('category.edit', $category))
        ->assertOk()
        ->assertSee('name')
        ->assertSee('description')
        ->assertSee('icon');
});

it('User without admin role can not access to edit Category form page', function () {

    $user = User::factory()->create();

    $category = Category::factory()->create();

    actingAs($user);

    get(route('category.edit', $category))
        ->assertRedirect(route('index'))
        ->assertSessionHas('error', 'Solo los administradores pueden ver y administrar categorias');
});

it('User with admin role can access to create form page', function () {

    $user = User::factory(
    )->create()->assignRole('admin');

    actingAs($user);

    get(route('category.create'))
        ->assertOk()
        ->assertSee('name')
        ->assertSee('description')
        ->assertSee('icon');
});

it('User without admin role cannot access to create form page', function () {

    $user = User::factory()->create();

    actingAs($user);

    get(route('category.create'))
        ->assertRedirect(route('index'))
        ->assertSessionHas('error', 'Solo los administradores pueden ver y administrar categorias');

});

it('Guest cannot access to edit Category form page', function () {

    $category = Category::factory()->create();

    get(route('category.edit', $category))
        ->assertRedirect('login');
});

it('Guest cannot access to create Category form page', function () {

    $category = Category::factory()->create();

    get(route('category.create'))
        ->assertRedirect('login');
});

it('Guest can access to his Cart', function () {
        get(route('cart.index'))
            ->assertOk();
});

it('User can access to his Cart', function () {

    $user = User::factory()->create();

    actingAs($user);

    get(route('cart.index'))
        ->assertOk();
});

it('User can access to a seller cart', function () {
    $user = User::factory()->create();

    $user2 = User::factory()->has(Product::factory()->count(3))->create();

    actingAs($user);

    post(route('cart.store', $user2->products->first()));

    get(route('cart.show', $user->sellerCarts()->first()))
        ->assertOk();

});

it('User can access to his panel product page', function () {

    $user = User::factory()->create();

    actingAs($user);

    get(route('my-products'))
        ->assertOk();
});

it('User can access to his sold page', function () {

    $user = User::factory()->create();

    actingAs($user);

    get(route('my-sold'))
        ->assertOk();
});

it('User can access to his sold page show', function () {
    $user = User::factory()->create();
    $user2 = User::factory()->has(Product::factory()->count(2))->create();
    $totalPrice = $user2->products->sum('price');

    $order = Order::factory()->create([
        'buyer_id' => $user->id,
        'seller_id' => $user2->id,
        'status' => 'paid',
        'total_price' => $totalPrice,
    ]);

    $order->orderItems()->create([
        'order_id' => $order->id,
        'product_id' => $user2->products->first()->id,
    ]);

    actingAs($user2);
    get(route('my-sold.show', $order))
        ->assertOk();

});


it('User can access to his order page', function () {

    $user = User::factory()->create();

    actingAs($user);

    get(route('my-orders'))
        ->assertOk();
});

it('User can access to his order page show', function () {

    $user = User::factory()->create();
    $user2 = User::factory()->has(Product::factory()->count(2))->create();
    $totalPrice = $user2->products->sum('price');

    $order = Order::factory()->create([
        'buyer_id' => $user->id,
        'seller_id' => $user2->id,
        'status' => 'paid',
        'total_price' => $totalPrice,
    ]);

    $order->orderItems()->create([
        'order_id' => $order->id,
        'product_id' => $user2->products->first()->id,
    ]);

    actingAs($user);
    get(route('my-orders.show', $order))
        ->assertOk();

});

it('users index route works', function () {
    get(route('users.index'))
        ->assertOk();
});

it('users show route works', function () {
    $user = User::factory()->create();
    get(route('users.show', $user))
        ->assertOk();
});

it('Admin can access to Discount codes page', function () {
    $user = User::factory()->create()->assignRole('admin');

    actingAs($user);

    get(route('discount-code'))
        ->assertOk();
});

it('Admin can access to Discount codes page form', function () {
    $user = User::factory()->create();

    $user->assignRole('admin');

    actingAs($user);

    get(route('discount-code.create'))
        ->assertOk();
});
