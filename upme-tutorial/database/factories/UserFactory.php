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
            'first_name'        => fake()->firstName(),
            'middle_name'       => fake()->lastName(),
            'last_name'         => fake()->lastName(),
            'email'             => fake()->unique()->safeEmail(),
            'password'          => Hash::make('password'), 
            'remember_token'    => Str::random(10),
            'avatar'            => 'avatars/default.jpg', 
            'date_hired'        => now(),
            'status'            => fake()->randomElement(['Active', 'Inactive', 'Terminated']),
            'position'          => fake()->jobTitle(),
            'department'        => fake()->randomElement([
                'Product and Technology',
                'Sales',
                'Marketing',
                'HR/Admin',
                'Finance'
            ]),
            'address'           => fake()->address(),
            'is_admin'          => fake()->boolean(20), 
            'email_verified_at' => now(),
            'remember_token'    => Str::random(10)
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
