<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

function loguedAsAdminUser(): void{
    roleSeeder();
    $user = User::factory()->create()->assignRole('admin');
    actingAs($user);
}

it('name field is required', function () {
    loguedAsAdminUser();
    $response = $this->post('/categories', [
        'name' => '',
        'description' => 'Category Description',
        'icon' => UploadedFile::fake()->image('icon.jpg')
    ]);

    $response->assertSessionHasErrors('name');
});


