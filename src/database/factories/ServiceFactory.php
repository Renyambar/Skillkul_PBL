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

        $titles = [
            'Jasa Pembuatan Website Company Profile',
            'Desain Logo Perusahaan Profesional',
            'Terjemahan Jurnal Bahasa Inggris ke Indonesia',
            'Jasa Input Data Excel Cepat dan Akurat',
            'Pembuatan Artikel SEO Friendly',
            'Desain Poster Event atau Lomba',
            'Jasa Edit Video Tugas Kampus',
            'Pembuatan UI/UX Aplikasi Mobile',
            'Bimbingan Belajar Pemrograman Web',
            'Jasa Analisis Data SPSS untuk Skripsi',
            'Fotografi Produk UMKM',
            'Jasa Pengetikan Ulang Dokumen'
        ];

        $descriptions = [
            'Saya akan mengerjakan proyek ini dengan profesional dan tepat waktu. Revisi bisa dilakukan hingga 2 kali tanpa biaya tambahan. Hasil dijamin memuaskan.',
            'Layanan ini mencakup pengerjaan dari awal hingga akhir dengan konsultasi gratis. Cocok untuk Anda yang membutuhkan hasil cepat dengan kualitas terbaik.',
            'Saya sudah berpengalaman lebih dari 2 tahun dalam bidang ini. Semua pekerjaan dilakukan secara manual tanpa bantuan aplikasi otomatis, sehingga hasilnya unik dan autentik.',
            'Harga yang tertera sudah termasuk semua file sumber (source code/file mentahan). Jangan ragu untuk berdiskusi terlebih dahulu sebelum memesan.',
            'Bagi mahasiswa yang sedang sibuk, saya siap membantu meringankan beban tugas Anda. Kerahasiaan data terjamin 100% dan dikerjakan sesuai pedoman yang diberikan.'
        ];

        return [
            'freelancer_id' => $freelancer->id,
            'category_id' => $category->id,
            'title' => fake()->randomElement($titles),
            'description' => fake()->randomElement($descriptions),
            'price' => fake()->randomFloat(2, 10000, 200000),
            'type' => fake()->randomElement(['non_project', 'project']),
            'is_active' => fake()->boolean(90), 
        ];
    }
}
