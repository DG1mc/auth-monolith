<?php

use App\Models\User;

test('registration screen can be rendered', function () {
    $this->get('/register')->assertStatus(200);
});

test('new users can register with default role user', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('user.dashboard', absolute: false));

    expect(User::where('email', 'test@example.com')->first()->role)->toBe('user');
});

test('registration cannot be used to self-assign the admin role', function () {
    $this->post('/register', [
        'name' => 'Sneaky User',
        'email' => 'sneaky@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => 'admin',
    ]);

    expect(User::where('email', 'sneaky@example.com')->first()->role)->toBe('user');
});

test('registration rejects a duplicate email', function () {
    $existing = User::factory()->create();

    $this->post('/register', [
        'name' => 'Dup',
        'email' => $existing->email,
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertSessionHasErrors('email');

    $this->assertGuest();
});
