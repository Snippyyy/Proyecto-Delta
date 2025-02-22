<?php

use App\Models\DiscountCode;
use App\Models\User;
use App\Policies\DiscountCodePolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    roleSeeder();
});

it('allows admin to view any discount code', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');
    $policy = new DiscountCodePolicy();
    expect($policy->viewAny($admin))->toBeTrue();
});

it('allows admin to create a discount code', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');
    $policy = new DiscountCodePolicy();
    expect($policy->create($admin))->toBeTrue();
});

it('allows admin to delete a discount code', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');
    $policy = new DiscountCodePolicy();
    $discountCode = new DiscountCode();
    expect($policy->delete($admin, $discountCode))->toBeTrue();
});

it('allows admin to toggle a discount code', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');
    $policy = new DiscountCodePolicy();
    expect($policy->toggle($admin))->toBeTrue();
});
