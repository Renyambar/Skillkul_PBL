<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    public function definition(): array
    {
        // Pastikan freelancer_id mengambil user dengan role 'freelancer'
        $freelancer = User::where('role', 'freelancer')->inRandomOrder()->first() ?? User::factory()->create(['role' => 'freelancer']);
        $category = Category::inRandomOrder()->first() ?? Category::factory()->create();

        return [
            'freelancer_id' => $freelancer->id,
            'category_id' => $category->id,
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(4),
            'price' => fake()->randomFloat(2, 10000, 200000),
            'type' => fake()->randomElement(['non_project', 'project']),
            'is_active' => fake()->boolean(90), 
        ];
    }
}
