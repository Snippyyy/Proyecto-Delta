<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Services\ProvinceService;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $provinces = ProvinceService::getAll();
        return [
            'name' => fake()->name(),
            'address' => fake()->address(),
            'postal_code' => fake()->postcode(),
            'phone_number' => fake()->phoneNumber(),
            'province' => $provinces[array_rand($provinces)],
            'email' => $email = fake()->unique()->safeEmail(),
            'avatar' => 'https://api.dicebear.com/5.x/avataaars/svg?seed=' . md5($email),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'user',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
