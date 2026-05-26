<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $categories = [
            'Desain Grafis', 'Joki Tugas', 'Pemrograman', 
            'Penulisan Artikel', 'Video Editing', 'Analisis Data'
        ];

        return [
            'name' => fake()->unique()->randomElement($categories),
            'description' => 'Kategori layanan profesional untuk bidang ' . strtolower(fake()->randomElement($categories)),
        ];
    }
}
