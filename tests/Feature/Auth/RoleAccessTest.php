<?php

use App\Models\User;

test('guests are redirected to login for protected routes', function (string $uri) {
    $this->get($uri)->assertRedirect('/login');
})->with(['/user/dashboard', '/admin/dashboard', '/admin/users', '/profile']);

test('regular users can access the user dashboard', function () {
    $this->actingAs(User::factory()->create())
        ->get('/user/dashboard')
        ->assertOk();
});

test('regular users get 403 on admin routes', function (string $uri) {
    $this->actingAs(User::factory()->create())
        ->get($uri)
        ->assertForbidden();
})->with(['/admin/dashboard', '/admin/users']);

test('admins can access the admin dashboard', function () {
    $this->actingAs(User::factory()->admin()->create())
        ->get('/admin/dashboard')
        ->assertOk()
        ->assertSee('Statistik Pengguna');
});

test('/dashboard redirects according to role', function () {
    $this->actingAs(User::factory()->create())
        ->get('/dashboard')
        ->assertRedirect(route('user.dashboard'));

    $this->actingAs(User::factory()->admin()->create())
        ->get('/dashboard')
        ->assertRedirect(route('admin.dashboard'));
});
