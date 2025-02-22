<?php

use App\Models\Product;
use App\Models\User;
use App\Policies\ProductPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

beforeEach(function () {
    roleSeeder();
});


it('allows authenticated user to create a product', function () {
    $policy = new ProductPolicy();
    $user = User::factory()->create();
    expect($policy->create($user))->toBeFalse();
    actingAs($user);
    expect($policy->create($user))->toBeTrue();
});

it('allows the seller to update their product', function () {
    $policy = new ProductPolicy();
    $user = User::factory()->create();
    $product = Product::factory()->create(['seller_id' => $user->id]);
    expect($policy->update($user, $product))->toBeTrue();
});

it('allows the seller to delete their product', function () {
    $policy = new ProductPolicy();
    $user = User::factory()->create();
    $product = Product::factory()->create(['seller_id' => $user->id]);
    expect($policy->delete($user, $product))->toBeTrue();
});
