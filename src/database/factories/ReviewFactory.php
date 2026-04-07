<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        $order = Order::where('status', 'completed')->inRandomOrder()->first() ?? Order::factory()->create(['status' => 'completed']);
        
        return [
            'order_id' => $order->id,
            'client_id' => $order->client_id,
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->boolean(80) ? fake()->sentence(10) : null,
        ];
    }
}
