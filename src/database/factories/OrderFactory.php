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
        $service = Service::inRandomOrder()->first() ?? Service::factory()->create();
        $freelancerId = $service->freelancer_id;

        return [
            'id' => Str::uuid()->toString(),
            'client_id' => User::where('role', 'client')->inRandomOrder()->first()->id ?? User::factory(),
            'freelancer_id' => $freelancerId,
            'service_id' => $service->id,
            'type' => fake()->randomElement(['direct_checkout', 'custom_invoice']),
            'status' => fake()->randomElement(['pending', 'paid', 'in_progress', 'delivered', 'completed', 'canceled']),
            'order_notes' => fake()->sentence(),
            'client_gdrive_link' => fake()->boolean(50) ? 'https://drive.google.com/...' : null,
            'freelancer_result_link' => fake()->boolean(30) ? 'https://drive.google.com/...' : null,
            'total_price' => $service->price,
            'midtrans_snap_token' => Str::random(20),
            'midtrans_transaction_id' => 'TRX-' . fake()->numerify('#####')
        ];
    }
}
