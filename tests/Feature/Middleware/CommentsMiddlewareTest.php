<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('User cannot post a comment if not logged in', function () {
    $user = User::factory()->create();


    $response = post(route('comments.store', $user->id), [
        'comment' => 'This is a comment',
    ]);

    $response->assertRedirect(route('users.show', ['user' => $user->name]))
        ->assertSessionHas('error', 'Debes iniciar sesión para comentar y comprar un articulo del usuario para poder comentar');
});

it('User cannot post a comment in his own profile', function () {
    $user = User::factory()->create();

    actingAs($user);

    $response = post(route('comments.store', $user->id), [
        'comment' => 'This is a comment',
    ]);

    $response->assertRedirect(route('users.show', ['user' => $user->name]))
        ->assertSessionHas('error', 'No puedes comentar tu propio perfil');
});

it('User cannot post a comment if he has not bought any product from the user', function () {
    $user = User::factory()->has(Product::factory()->count(3))->create();
    $user2 = User::factory()->create();

    actingAs($user2);

    $response = post(route('comments.store', $user->id), [
        'comment' => 'This is a comment',
    ]);

    $response->assertRedirect(route('users.show', ['user' => $user->name]))
        ->assertSessionHas('error', 'Debes comprar un articulo del usuario para poder comentar');
});
