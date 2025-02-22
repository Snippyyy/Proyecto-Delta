<?php

use App\Models\Category;
use App\Models\User;
use App\Policies\CategoryPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    roleSeeder();
});

it('allows admin to view any category', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');
    $policy = new CategoryPolicy();
    expect($policy->viewAny($admin))->toBeTrue();
});


it('allows admin to create a category', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');
    $policy = new CategoryPolicy();
    expect($policy->create($admin))->toBeTrue();
});

it('allows admin to update a category', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');
    $policy = new CategoryPolicy();
    $category = new Category();
    expect($policy->update($admin, $category))->toBeTrue();
});

it('allows admin to delete a category', function () {
    $policy = new CategoryPolicy();
    $admin = User::factory()->create();
    $admin->assignRole('admin');
    $category = new Category();
    expect($policy->delete($admin, $category))->toBeTrue();
});
