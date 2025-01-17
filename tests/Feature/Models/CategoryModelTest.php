<?php

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

//relationship
it('has many products', function () {
    $category = Category::factory()->hasProducts(3)->create();
    expect($category->products)->toHaveCount(3);
});


