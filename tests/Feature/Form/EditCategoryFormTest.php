<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

function loguedAsAdminUserAndCategory(): void{

    roleSeeder();
    $user = User::factory()->create()->assignRole('admin');
    Category::factory()->create();
    actingAs($user);
}

it('name field is required', function () {

    loguedAsAdminUserAndCategory();

    $category = Category::first();

    $response = $this->patch('/categories/' . $category->id, [
        'name' => '',
        'description' => 'Category Description',
        'icon' => UploadedFile::fake()->image('icon.jpg')
    ]);

    $response->assertSessionHasErrors('name');
});
