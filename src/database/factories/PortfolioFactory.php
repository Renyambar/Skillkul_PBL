<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortfolioFactory extends Factory
{
    public function definition(): array
    {
        $order = Order::where('status', 'completed')->inRandomOrder()->first() ?? Order::factory()->create(['status' => 'completed']);

        return [
            'freelancer_id' => $order->freelancer_id,
            'order_id' => $order->id,
            'project_title' => 'Project: ' . fake()->sentence(3),
            'completed_date' => fake()->date(),
            'pdf_file_path' => 'portfolios/resume_' . $order->freelancer_id . '.pdf'
        ];
    }
}
