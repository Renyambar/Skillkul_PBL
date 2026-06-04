<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Pemrograman & Teknologi', 'icon' => '💻', 'description' => 'Web, mobile, desktop, dan pengembangan software lainnya'],
            ['name' => 'Desain Grafis & Visual',  'icon' => '🎨', 'description' => 'Logo, poster, ilustrasi, dan desain kreatif lainnya'],
            ['name' => 'UI/UX & Wireframe',        'icon' => '📐', 'description' => 'Desain antarmuka, prototyping, dan user experience'],
            ['name' => 'Penulisan & Konten',       'icon' => '✍️', 'description' => 'Artikel, copywriting, proofreading, dan pembuatan konten'],
            ['name' => 'Analisis Data',            'icon' => '📊', 'description' => 'Pengolahan data, statistik, visualisasi, dan riset'],
            ['name' => 'Multimedia & Video',       'icon' => '🎬', 'description' => 'Editing video, animasi, motion graphic, dan podcast'],
            ['name' => 'Administrasi & Bisnis',    'icon' => '📋', 'description' => 'Entry data, laporan, presentasi, dan dokumen bisnis'],
            ['name' => 'Akademik & Pendidikan',    'icon' => '🎓', 'description' => 'Bimbingan belajar, terjemahan, dan tugas akademik'],
        ];

        foreach ($categories as $data) {
            Category::firstOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}
