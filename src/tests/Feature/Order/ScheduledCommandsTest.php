<?php

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Log;

test('orders:auto-complete completes orders delivered over 48 hours ago', function () {
    // Create a freelancer with a specific wallet balance
    $freelancer = User::factory()->freelancer()->create(['wallet_balance' => 1000]);

    // Create an order delivered 49 hours ago
    $order = Order::factory()->create([
        'freelancer_id' => $freelancer->id,
        'status' => 'delivered',
        'updated_at' => now()->subHours(49),
        'total_price' => 100000,
    ]);

    // Run the artisan command
    $this->artisan('orders:auto-complete')->assertExitCode(0);

    // Refresh order from db
    $order->refresh();
    $freelancer->refresh();

    // Assert status is completed
    expect($order->status)->toBe('completed');

    // Assert wallet balance increased by 95% of total price
    // 1000 + (100000 * 0.95) = 1000 + 95000 = 96000
    expect((float) $freelancer->wallet_balance)->toBe(96000.0);
});

test('orders:auto-complete ignores orders delivered less than 48 hours ago', function () {
    $freelancer = User::factory()->freelancer()->create(['wallet_balance' => 0]);

    $order = Order::factory()->create([
        'freelancer_id' => $freelancer->id,
        'status' => 'delivered',
        'updated_at' => now()->subHours(24),
        'total_price' => 100000,
    ]);

    $this->artisan('orders:auto-complete')->assertExitCode(0);

    $order->refresh();
    $freelancer->refresh();

    // Order should remain delivered
    expect($order->status)->toBe('delivered');
    // Wallet should remain 0
    expect((float) $freelancer->wallet_balance)->toBe(0.0);
});

test('orders:deadline-reminders logs reminders for deadlines within 24 hours', function () {
    Log::shouldReceive('info')
        ->once()
        ->withArgs(function ($message, $context) {
            return str_contains($message, '[DeadlineReminder]') &&
                isset($context['order_id']) &&
                isset($context['hours_left']);
        });

    $order = Order::factory()->create([
        'status' => 'in_progress',
        'deadline' => now()->addHours(12), // 12 hours from now
    ]);

    $this->artisan('orders:deadline-reminders')->assertExitCode(0);
});

test('orders:deadline-reminders ignores deadlines far in the future', function () {
    Log::shouldReceive('info')->never();

    $order = Order::factory()->create([
        'status' => 'in_progress',
        'deadline' => now()->addHours(48), // 48 hours from now
    ]);

    $this->artisan('orders:deadline-reminders')->assertExitCode(0);
});
