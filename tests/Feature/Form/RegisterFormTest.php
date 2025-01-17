<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('name field is required', function () {
    $response = $this->post('/register', [
        'name' => '',
        'email' => 'ejemplo@mail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'province' => 'Murcia',
        'address' => 'Murcia',
        'postal_code' => '30001',
        'phone' => '666666666',
    ]);

    $response->assertSessionHasErrors('name');
});

it('email field is required', function () {
    $response = $this->post('/register', [
        'name' => 'Ejemplo',
        'email' => '',
        'password' => 'password',
        'password_confirmation' => 'password',
        'province' => 'Murcia',
        'address' => 'Murcia',
        'postal_code' => '30001',
        'phone' => '666666666',
    ]);

    $response->assertSessionHasErrors('email');
});

it('password field is required', function () {
    $response = $this->post('/register', [
        'name' => 'Ejemplo',
        'email' => 'ejemplo@mail.com',
        'password' => '',
        'password_confirmation' => 'password',
        'province' => 'Murcia',
        'address' => 'Murcia',
        'postal_code' => '30001',
        'phone' => '666666666',
    ]);

    $response->assertSessionHasErrors('password');
});

it('password confirmation field is required', function () {
    $response = $this->post('/register', [
        'name' => 'Ejemplo',
        'email' => 'ejemplo@mail.com',
        'password' => 'password',
        'password_confirmation' => '',
        'province' => 'Murcia',
        'address' => 'Murcia',
        'postal_code' => '30001',
        'phone' => '666666666',
    ]);

    $response->assertSessionHasErrors('password');

    $response = $this->post('/register', [
        'name' => 'Ejemplo',
        'email' => 'ejemplo@mail.com',
        'password' => 'password',
        'password_confirmation' => 'password2',
        'province' => 'Murcia',
        'address' => 'Murcia',
        'postal_code' => '30001',
        'phone' => '666666666',
    ]);

    $response->assertSessionHasErrors('password');
});

it('province field is required', function () {
    $response = $this->post('/register', [
        'name' => 'Ejemplo',
        'email' => 'ejemplo@mail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'province' => '',
        'address' => 'Murcia',
        'postal_code' => '30001',
        'phone' => '666666666',
    ]);

    $response->assertSessionHasErrors('province');

    $response = $this->post('/register', [
        'name' => 'Ejemplo',
        'email' => 'ejemplo@mail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'province' => 'Noexistente',
        'address' => 'Murcia',
        'postal_code' => '30001',
        'phone' => '666666666',
    ]);

    $response->assertSessionHasErrors('province');
});

it('address field is required', function () {
    $response = $this->post('/register', [
        'name' => 'Ejemplo',
        'email' => 'ejemplo@mail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'province' => 'Murcia',
        'address' => '',
        'postal_code' => '30001',
        'phone' => '666666666',
    ]);

    $response->assertSessionHasErrors('address');
});

it('postal code field is required', function () {
    $response = $this->post('/register', [
        'name' => 'Ejemplo',
        'email' => 'ejemplo@mail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'province' => 'Murcia',
        'address' => 'Murcia',
        'postal_code' => '',
        'phone' => '666666666',
    ]);

    $response->assertSessionHasErrors('postal_code');
});

it('phone field is required', function () {
    $response = $this->post('/register', [
        'name' => 'Ejemplo',
        'email' => 'ejemplo@mail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'province' => 'Murcia',
        'address' => 'Murcia',
        'postal_code' => '30001',
        'phone_number' => '',
    ]);

    $response->assertSessionHasErrors('phone_number');
});





