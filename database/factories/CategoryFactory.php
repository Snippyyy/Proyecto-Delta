<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Consolas','Televisiones','Peliculas','Varios'];
        return [
            'name' => $name = $categories[array_rand($categories)],
            'description' => $this->faker->text(),
            'icon' => 'https://api.dicebear.com/6.x/icons/svg?seed='. md5($name),
        ];
    }
}
