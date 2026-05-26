<?php

use App\Models\User;

test('registration choice screen can be rendered', function () {
    $response = $this->get('/register');
    $response->assertStatus(200);
});

test('client registration screen can be rendered', function () {
    $response = $this->get('/register/client');
    $response->assertStatus(200);
});

test('freelancer registration screen can be rendered', function () {
    $response = $this->get('/register/freelancer');
    $response->assertStatus(200);
});

test('clients can register with any email', function () {
    $response = $this->post('/register/client', [
        'name' => 'Test Client',
        'email' => 'client@gmail.com', // Any email allowed
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('verification.notice', absolute: false));
    
    $user = User::where('email', 'client@gmail.com')->first();
    expect($user->role)->toBe('client')
        ->and($user->verification_type)->toBe('none')
        ->and($user->nim)->toBeNull();
});

test('freelancers can register with college email', function () {
    $response = $this->post('/register/freelancer/college', [
        'name' => 'Test Freelancer College',
        'email' => 'freelancer@mahasiswa.polinema.ac.id', // Valid .ac.id email
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('verification.notice', absolute: false));
    
    $user = User::where('email', 'freelancer@mahasiswa.polinema.ac.id')->first();
    expect($user->role)->toBe('freelancer')
        ->and($user->verification_type)->toBe('college_email')
        ->and($user->nim)->toBeNull();
});

test('freelancer college registration fails with non-college email', function () {
    $response = $this->post('/register/freelancer/college', [
        'name' => 'Hacker Man',
        'email' => 'hacker@gmail.com', // Invalid email, should trigger CollegeEmail rule
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors(['email']);
});

test('freelancers can register with valid nim', function () {
    $currentYear = date('y');
    $validNim = $currentYear . '41070' . '0001';

    $response = $this->post('/register/freelancer/nim', [
        'name' => 'Test Freelancer NIM',
        'email' => 'freelancer.nim@gmail.com', 
        'nim' => $validNim,
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('verification.notice', absolute: false));
    
    $user = User::where('email', 'freelancer.nim@gmail.com')->first();
    expect($user->role)->toBe('freelancer')
        ->and($user->verification_type)->toBe('nim')
        ->and($user->nim)->toBe($validNim);
});

test('freelancer nim registration fails with invalid nim format', function () {
    $response = $this->post('/register/freelancer/nim', [
        'name' => 'Invalid NIM User',
        'email' => 'invalid.nim@gmail.com', 
        'nim' => '24123450001', // Invalid institution code
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors(['nim']);
});
