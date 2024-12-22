<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('First page response', function () {
    //Arrange

    //Act
    get(route('welcome'))->assertOk();
    //Assert

});

it('Login page response', function () {

    //Arrange

    //Act & //Assert
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

it('Products page response', function () {
    get(route('product.index'))->assertOk();
});

it('Guest cannot create Products', function () {
    get(route('product.create'))->assertRedirect('login');
});
it('Auth user can create products', function () {

    $user = User::factory()->create();

    actingAs($user);
    get(route('product.create'))->assertOk();
});

it('Product show page response', function () {

    $product = Product::factory()->create();

    get(route('product.show', $product))->assertOk();
});

it('Category page response', function () {
    get(route('category.index'))->assertOk();
});

it('Category show page response', function () {
    $category = Category::factory()->create();
    get(route('category.show', $category))->assertOk();
});



