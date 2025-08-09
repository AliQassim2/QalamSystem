<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        return [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->optional()->phoneNumber(),
            'role' => fake()->numberBetween(0, 5), // Assuming roles are defined as integers
            'state' => fake()->numberBetween(0, 1), // Assuming state is active/inactive
            'email_verified_at' => rand(0, 1) ? now() : null,
            'password' => static::$password ??= Hash::make('password'),
            'tokenremember' => Str::random(10),
            'token_expires_at' => now()->addHour(),
            'code_login' => rand(0, 1) ? Str::random(6) : null, // Random 6-character code for
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
