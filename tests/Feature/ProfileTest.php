<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/my-zone/profile');

    $response->assertOk();
});

test('profile information can be updated', function () {

    Storage::fake('public');
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/my-zone/profile', [
            'name' => 'Test User',
            'avatar' => UploadedFile::fake()->image('avatar.jpg'),
            'email' => 'actualizado@mail.es',
            'province' => 'Murcia',
            'address' => 'Calle de la piruleta',
            'postal_code' => '03001',
            'phone_number' => '123456789',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/my-zone/profile');

    $user->refresh();

    $this->assertStringContainsString('avatars/', $user->avatar);
    $this->assertSame('Test User', $user->name);
    $this->assertSame('actualizado@mail.es', $user->email);
    $this->assertNull($user->email_verified_at);
    $this->assertNotNull($user->avatar);
    $this->assertNotNull($user->avatar);
    $this->assertSame('Murcia', $user->province);
    $this->assertSame('Calle de la piruleta', $user->address);
    $this->assertSame('03001', $user->postal_code);
    $this->assertSame('123456789', $user->phone_number);
});

test('email verification status is unchanged when the email address is unchanged', function () {

    Storage::fake('public');
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/my-zone/profile', [
            'name' => 'Test User',
            'email' => $user->email,
            'avatar' => UploadedFile::fake()->image('avatar.jpg'),
            'province' => 'Murcia',
            'address' => 'Calle de la piruleta',
            'postal_code' => '03001',
            'phone_number' => '123456789',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/my-zone/profile');

    $user->refresh();

    $this->assertStringContainsString('avatars/', $user->avatar);
    $this->assertSame('Test User', $user->name);
    $this->assertSame($user->email, $user->email);
    $this->assertNotNull($user->email_verified_at);
    $this->assertNotNull($user->avatar);
    $this->assertSame('Murcia', $user->province);
    $this->assertSame('Calle de la piruleta', $user->address);
    $this->assertSame('03001', $user->postal_code);
    $this->assertSame('123456789', $user->phone_number);
});

test('user can delete their account', function () {


    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->delete('/my-zone/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $this->assertGuest();
    $this->assertNull($user->fresh());
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/my-zone/profile')
        ->delete('/my-zone/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrorsIn('userDeletion', 'password')
        ->assertRedirect('/my-zone/profile');

    $this->assertNotNull($user->fresh());
});

