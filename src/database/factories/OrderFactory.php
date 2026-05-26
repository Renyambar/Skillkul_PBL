<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        $service      = Service::inRandomOrder()->first() ?? Service::factory()->create();
        $freelancerId = $service->freelancer_id;

        // Pastikan client_id mengambil user dengan role 'client'
        $client = User::where('role', 'client')->inRandomOrder()->first()
            ?? User::factory()->client()->create();

        // Status distribusi yang realistis untuk demo data
        $status = fake()->randomElement([
            'pending', 'pending',
            'waiting_payment',
            'paid',
            'in_progress', 'in_progress', 'in_progress',
            'delivered', 'delivered',
            'revision',
            'completed', 'completed', 'completed', 'completed',
            'canceled',
        ]);

        // Deadline hanya relevan untuk in_progress / revision / delivered
        $deadline = in_array($status, ['in_progress', 'revision', 'delivered'])
            ? fake()->dateTimeBetween('now', '+7 days')
            : null;

        // Revision count hanya diisi jika ada atau pernah ada revisi
        $revisionLimit = fake()->randomElement([1, 2]);
        $revisionCount = in_array($status, ['revision', 'delivered', 'completed'])
            ? fake()->numberBetween(0, $revisionLimit)
            : 0;

        // Hasil pekerjaan hanya ada jika sudah delivered/completed
        $resultLink = in_array($status, ['delivered', 'completed'])
            ? 'https://drive.google.com/drive/folders/' . Str::random(28)
            : null;

        // Snap token hanya relevan untuk status pembayaran
        $snapToken = in_array($status, ['pending', 'waiting_payment'])
            ? Str::random(36)
            : null;

        $notes = [
            'Tolong kerjakan sesuai dengan panduan yang saya kirimkan di Google Drive ya. Terima kasih!',
            'Bisa tolong selesaikan sebelum hari Jumat? Saya butuh cepat untuk presentasi.',
            'Mohon perhatikan detail warna dan font yang sudah disepakati.',
            'File mentahan sudah saya cantumkan di link. Mohon segera diproses.',
            'Jika ada yang kurang jelas, silakan langsung hubungi saya via chat.',
            'Tolong buatkan yang minimalis dan elegan. Jangan terlalu ramai warnanya.',
            'Sesuai diskusi kita kemarin ya kak.',
            'Tolong dicek kembali ejaan dan tanda bacanya agar tidak ada typo.'
        ];

        return [
            'id'                      => Str::uuid()->toString(),
            'client_id'               => $client->id,
            'freelancer_id'           => $freelancerId,
            'service_id'              => $service->id,
            'type'                    => fake()->randomElement(['direct_checkout', 'custom_invoice']),
            'status'                  => $status,
            'order_notes'             => fake()->randomElement($notes),
            'deadline'                => $deadline,
            'revision_count'          => $revisionCount,
            'revision_limit'          => $revisionLimit,
            'client_gdrive_link'      => fake()->boolean(50)
                                            ? 'https://drive.google.com/drive/folders/' . Str::random(28)
                                            : null,
            'freelancer_result_link'  => $resultLink,
            'total_price'             => $service->price,
            'midtrans_snap_token'     => $snapToken,
            'midtrans_transaction_id' => in_array($status, ['paid', 'in_progress', 'delivered', 'completed'])
                                            ? 'TRX-' . fake()->numerify('#########')
                                            : null,
        ];
    }
}
