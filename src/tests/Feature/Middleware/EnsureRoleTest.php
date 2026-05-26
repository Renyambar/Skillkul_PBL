<?php

use App\Models\User;

test('freelancers cannot access admin routes', function () {
    $freelancer = User::factory()->freelancer()->create();

    $response = $this->actingAs($freelancer)->get('/admin/laporan');

    $response->assertStatus(403);
});

test('clients cannot access freelancer routes', function () {
    $client = User::factory()->client()->create();

    $response = $this->actingAs($client)->get('/freelancer/dasbor');

    $response->assertStatus(403);
});

test('admins can access admin routes', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get('/admin/laporan');

    $response->assertStatus(200);
});

test('freelancers can access freelancer routes', function () {
    $freelancer = User::factory()->freelancer()->create();

    $response = $this->actingAs($freelancer)->get('/freelancer/dasbor');

    $response->assertStatus(200);
});

test('guests are redirected to login', function () {
    $response = $this->get('/freelancer/dasbor');
    $response->assertRedirect('/login');

    $response2 = $this->get('/admin/laporan');
    $response2->assertRedirect('/login');
});
