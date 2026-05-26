<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        // 4. Review hanya dibuat untuk order yang berstatus 'completed'
        $order = Order::where('status', 'completed')->inRandomOrder()->first() ?? Order::factory()->create(['status' => 'completed']);
        
        $comments = [
            'Pekerjaan sangat memuaskan, freelancer sangat komunikatif.',
            'Hasil cepat dan sesuai ekspektasi. Terima kasih!',
            'Sedikit terlambat dari tenggat waktu, tapi hasilnya bagus.',
            'Sangat direkomendasikan! Akan pesan lagi di lain waktu.',
            'Pengerjaan rapi dan profesional. Harga juga sangat bersahabat untuk mahasiswa.',
            'Revisi dikerjakan dengan cepat. Puas banget sama pelayanannya.',
            'Biasa saja, tapi cukup membantu untuk tugas mendadak.',
            'Kualitas luar biasa! Jauh melampaui ekspektasi saya.'
        ];

        return [
            'order_id' => $order->id,
            'client_id' => $order->client_id,
            'rating' => fake()->numberBetween(3, 5), // Reviews usually lean positive
            'comment' => fake()->boolean(80) ? fake()->randomElement($comments) : null,
        ];
    }
}
