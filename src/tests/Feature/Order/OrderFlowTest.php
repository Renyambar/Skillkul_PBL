<?php

use App\Models\Order;
use App\Models\User;

test('client can request a revision if limit allows', function () {
    $client = User::factory()->client()->create();
    $freelancer = User::factory()->freelancer()->create();

    $order = Order::factory()->create([
        'client_id' => $client->id,
        'freelancer_id' => $freelancer->id,
        'status' => 'delivered',
        'revision_count' => 0,
        'revision_limit' => 2,
    ]);

    $response = $this->actingAs($client)
        ->from(route('pesanan.detail', $order->id))
        ->post("/pesanan/{$order->id}/minta-revisi");

    $response->assertRedirect(route('pesanan.detail', $order->id));
    $response->assertSessionHas('success');

    $order->refresh();

    expect($order->status)->toBe('revision')
        ->and($order->revision_count)->toBe(1);
});

test('client cannot request revision if limit exhausted', function () {
    $client = User::factory()->client()->create();

    $order = Order::factory()->create([
        'client_id' => $client->id,
        'status' => 'delivered',
        'revision_count' => 2, // Used 2 out of 2
        'revision_limit' => 2,
    ]);

    $response = $this->actingAs($client)
        ->from(route('pesanan.detail', $order->id))
        ->post("/pesanan/{$order->id}/minta-revisi");

    $response->assertRedirect(route('pesanan.detail', $order->id));
    $response->assertSessionHas('error');

    $order->refresh();

    expect($order->status)->toBe('delivered')
        ->and($order->revision_count)->toBe(2);
});

test('client can accept order and escrow is released to freelancer', function () {
    $client = User::factory()->client()->create();
    $freelancer = User::factory()->freelancer()->create(['wallet_balance' => 0]);

    $order = Order::factory()->create([
        'client_id' => $client->id,
        'freelancer_id' => $freelancer->id,
        'status' => 'delivered',
        'total_price' => 100000,
    ]);

    $response = $this->actingAs($client)
        ->from(route('pesanan.detail', $order->id))
        ->post("/pesanan/{$order->id}/terima", [
            'rating' => 5,
            'comment' => 'Great work!',
        ]);

    $response->assertRedirect(route('pesanan.detail', $order->id));

    $order->refresh();
    $freelancer->refresh();

    // Order status should be completed
    expect($order->status)->toBe('completed');

    // Escrow released (95% to freelancer)
    expect((float) $freelancer->wallet_balance)->toBe(95000.0);

    // Review should be created
    $this->assertDatabaseHas('reviews', [
        'order_id' => $order->id,
        'client_id' => $client->id,
        'rating' => 5,
        'comment' => 'Great work!',
    ]);
});
