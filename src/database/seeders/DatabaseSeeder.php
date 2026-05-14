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
        // 3. Tambahkan user admin
        User::factory()->create([
            'name' => 'Admin SkillKul',
            'email' => 'admin@skillkul.com',
            'role' => 'admin',
        ]);

        $categories = [
            ['name' => 'Desain Presentasi', 'description' => 'Bikin slide PPT keren dan estetik buat tugas akhir atau semhas.'],
            ['name' => 'Joki Tugas Koding', 'description' => 'Bantuan mengerjakan tugas Web, Java, Python, dll.'],
            ['name' => 'Ketikan & Makalah', 'description' => 'Pembuatan makalah, merangkum materi, dan terjemahan.'],
            ['name' => 'Video Editing', 'description' => 'Edit video tugas kelompok agar terlihat profesional.'],
        ];
        foreach ($categories as $cat) {
            Category::create($cat);
        }

        User::factory(10)->create(['role' => 'freelancer']);
        User::factory(10)->create(['role' => 'client']);

        User::factory()->create([
            'name' => 'Test Freelancer',
            'email' => 'freelancer@skillkul.com',
            'role' => 'freelancer',
        ]);
        User::factory()->create([
            'name' => 'Test Client',
            'email' => 'client@skillkul.com',
            'role' => 'client',
        ]);

        Service::factory(20)->create();
        Order::factory(30)->create();

        // 4. Review dan Portfolio hanya untuk order berstatus 'completed'
        $completedOrders = Order::where('status', 'completed')->get();
        foreach ($completedOrders as $order) {
            if (rand(1, 100) <= 70) {
                Review::factory()->create([
                    'order_id' => $order->id,
                    'client_id' => $order->client_id,
                ]);
            }
            Portfolio::factory()->create([
                 'order_id' => $order->id,
                 'freelancer_id' => $order->freelancer_id,
            ]);
        }
    }
}
