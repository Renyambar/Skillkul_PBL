<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'freelancer_id' => User::where('role', 'freelancer')->inRandomOrder()->first()->id ?? User::factory(),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(4),
            'price' => fake()->randomFloat(2, 10000, 200000),
            'type' => fake()->randomElement(['non_project', 'project']),
            'is_active' => fake()->boolean(90), 
        ];
    }
}
