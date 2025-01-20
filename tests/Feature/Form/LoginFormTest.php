<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function createUser()
{
    $user = User::factory()->create([
        'email' => 'test@hotmail.com',
        'password' => 'password',
    ]);
    return $user;
}

it('email field is required', function () {

    $user = createUser();

    $response = $this->post('/login', [
        'password' => 'password',
        ]);

    $response->assertSessionHasErrors('email')
        ->assertSessionDoesntHaveErrors('password');
});

it('password field is required', function () {
    $user = createUser();

    $response = $this->post('/login', [
        'email' => 'test@hotmail.com',
    ]);

    $response->assertSessionHasErrors('password')
        ->assertSessionDoesntHaveErrors('email');
});

it('login success', function () {
    $user = createUser();

    $response = $this->post('/login', [
        'email' => 'test@hotmail.com',
        'password' => 'password',
    ]);

    $response->assertSessionDoesntHaveErrors('password')
        ->assertSessionDoesntHaveErrors('email')
        ->assertRedirect(route('dashboard'));
});

it('no fields', function () {
    $user = createUser();

    $response = $this->post('/login', [

    ]);

    $response->assertSessionHasErrors('email')
        ->assertSessionHasErrors('password');
});



