<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

function loguedUser(): void
{
    $user = User::factory()->create();
    actingAs($user);
}

it('name field is required', function () {

    loguedUser();
    Category::factory()->create();

    $response = $this->post('/products', [
        'name' => '',
        'description' => 'description',
        'price' => '10',
        'shipment' => true,
        'category_id' => '1',
        'img_path' => [
            UploadedFile::fake()->image('imagen1.png'),
            UploadedFile::fake()->image('imagen2.png')
        ],
    ]);

    $response->assertSessionHasErrors('name');
});
it('description field is required', function () {

    loguedUser();
    Category::factory()->create();

    $response = $this->post('/products', [
        'name' => 'Product Name',
        'description' => '',
        'price' => '10',
        'shipment' => true,
        'category_id' => '1',
        'img_path' => [
            UploadedFile::fake()->image('imagen1.png'),
            UploadedFile::fake()->image('imagen2.png')
        ],
    ]);

    $response->assertSessionHasErrors('description');
});

it('price field is required', function () {

    loguedUser();
    Category::factory()->create();

    $response = $this->post('/products', [
        'name' => 'Product Name',
        'description' => 'description',
        'price' => '',
        'shipment' => true,
        'category_id' => '1',
        'img_path' => [
            UploadedFile::fake()->image('imagen1.png'),
            UploadedFile::fake()->image('imagen2.png')
        ],
    ]);

    $response->assertSessionHasErrors('price');
});

it('category_id field is required', function () {

    loguedUser();
    Category::factory()->create();

    $response = $this->post('/products', [
        'name' => 'Product Name',
        'description' => 'description',
        'price' => '10',
        'shipment' => false,
        'category_id' => '',
        'img_path' => [
            UploadedFile::fake()->image('imagen1.png'),
            UploadedFile::fake()->image('imagen2.png')
        ],
    ]);

    $response->assertSessionHasErrors('category_id');
});

it('image path field is required', function () {

    loguedUser();
    Category::factory()->create();

    $response = $this->post('/products', [
        'name' => 'Product Name',
        'description' => 'description',
        'price' => '10',
        'shipment' => false,
        'category_id' => '1',
        'img_path' => '',
    ]);

    $response->assertSessionHasErrors('img_path');
});


