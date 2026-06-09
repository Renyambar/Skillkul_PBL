<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Service;
use App\Models\Order;
use App\Models\Review;
use App\Models\Portfolio;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── 1. Akun Admin ────────────────────────────────────────────────────
        // Admin menggunakan email internal — dikecualikan dari validasi .ac.id
        // karena admin dibuat via seeder, bukan registrasi publik.
        User::factory()->create([
            'name'      => 'Admin SkillKul',
            'email'     => 'admin@skillkul.com',
            'role'      => 'admin',
            'nim'       => null,
            'is_active' => true,
        ]);

        // ─── 2. Akun Test (login mudah untuk development) ─────────────────────
        User::factory()->create([
            'name'      => 'Test Freelancer',
            'email'     => 'freelancer@polinema.ac.id',
            'role'      => 'freelancer',
            'nim'       => '2241760001',
            'is_active' => true,
        ]);

        User::factory()->create([
            'name'      => 'Test Client',
            'email'     => 'client@polinema.ac.id',
            'role'      => 'client',
            'nim'       => null,
            'is_active' => true,
        ]);

        // ─── 3. Kategori Jasa ─────────────────────────────────────────────────
        $categories = [
            ['name' => 'Desain Presentasi',  'description' => 'Bikin slide PPT keren dan estetik buat tugas akhir atau semhas.'],
            ['name' => 'Bantuan Tugas Pemrograman',  'description' => 'Bantuan mengerjakan tugas Web, Java, Python, dll.'],
            ['name' => 'Pengetikan & Makalah',  'description' => 'Pembuatan makalah, merangkum materi, dan terjemahan.'],
            ['name' => 'Penyuntingan Video',      'description' => 'Edit video tugas kelompok agar terlihat profesional.'],
            ['name' => 'Desain Grafis',      'description' => 'Poster, banner, infografis, dan aset visual lainnya.'],
            //['name' => 'Terjemahan',         'description' => 'Alih bahasa dokumen Indonesia-Inggris dan sebaliknya.'],
        ];
        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // ─── 4. Freelancer & Client Acak ──────────────────────────────────────
        // UserFactory kini menghasilkan email .ac.id otomatis
        User::factory(15)->freelancer()->create();
        User::factory(15)->client()->create();

        // ─── 5. Layanan (Jasa) ────────────────────────────────────────────────
        Service::factory(25)->create();

        // ─── 6. Pesanan ───────────────────────────────────────────────────────
        // OrderFactory kini menghasilkan deadline, revision_count, revision_limit
        Order::factory(40)->create();

        // ─── 7. Review & Portfolio untuk pesanan 'completed' ──────────────────
        $completedOrders = Order::where('status', 'completed')->get();

        foreach ($completedOrders as $order) {
            // 70% chance client memberikan review
            if (rand(1, 100) <= 70) {
                Review::factory()->create([
                    'order_id'  => $order->id,
                    'client_id' => $order->client_id,
                ]);
            }

            // Portfolio otomatis untuk semua completed order (sebagai showcase freelancer)
            Portfolio::factory()->create([
                'order_id'      => $order->id,
                'freelancer_id' => $order->freelancer_id,
            ]);
        }

        $this->command->info('✅ Seeding selesai!');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin',      'admin@skillkul.com',      'password'],
                ['Freelancer', 'freelancer@polinema.ac.id', 'password'],
                ['Client',     'client@polinema.ac.id',   'password'],
            ]
        );
    }
}
