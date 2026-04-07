<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => fake()->randomElement(['freelancer', 'client']),
            'phone_number' => fake()->numerify('08##########'),
            'profile_description' => fake()->boolean(70) ? fake()->sentence(15) : null,
            'is_exam_mode' => fake()->boolean(20),
            'is_auto_portfolio' => fake()->boolean(80),
            'wallet_balance' => fake()->randomFloat(2, 0, 500000),
            'remember_token' => Str::random(10),
        ];
    }
}
