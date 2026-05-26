<?php

use App\Models\User;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('clients can register without nim using ac.id email', function () {
    $response = $this->post('/register', [
        'name' => 'Test Client',
        'email' => 'client@student.ub.ac.id', // Valid .ac.id email
        'phone_number' => '081234567890',
        'role' => 'client',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->dump();
    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
    
    $user = User::where('email', 'client@student.ub.ac.id')->first();
    expect($user->role)->toBe('client')
        ->and($user->nim)->toBeNull();
});

test('freelancers can register with nim using ac.id email', function () {
    $response = $this->post('/register', [
        'name' => 'Test Freelancer',
        'email' => 'freelancer@mahasiswa.polinema.ac.id', // Valid .ac.id email
        'phone_number' => '081234567891',
        'role' => 'freelancer',
        'nim' => '2241760001',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
    
    $user = User::where('email', 'freelancer@mahasiswa.polinema.ac.id')->first();
    expect($user->role)->toBe('freelancer')
        ->and($user->nim)->toBe('2241760001');
});

test('registration fails with non-college email', function () {
    $response = $this->post('/register', [
        'name' => 'Hacker Man',
        'email' => 'hacker@gmail.com', // Invalid email, should trigger CollegeEmail rule
        'phone_number' => '081234567892',
        'role' => 'client',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors(['email']);
});
