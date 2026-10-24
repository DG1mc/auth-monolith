<?php

use App\Models\User;

test('admin can list users', function () {
    $admin = User::factory()->admin()->create();
    $other = User::factory()->create(['name' => 'Budi Santoso']);

    $this->actingAs($admin)
        ->get('/admin/users')
        ->assertOk()
        ->assertSee('Budi Santoso');
});

test('admin can change the role of another user', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create();

    $this->actingAs($admin)
        ->patch("/admin/users/{$user->id}/role", ['role' => 'admin'])
        ->assertSessionHas('status');

    expect($user->fresh()->role)->toBe('admin');
});

test('admin cannot assign an unknown role', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create();

    $this->actingAs($admin)
        ->patch("/admin/users/{$user->id}/role", ['role' => 'superuser'])
        ->assertSessionHasErrors('role');

    expect($user->fresh()->role)->toBe('user');
});

test('admin cannot change their own role', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->patch("/admin/users/{$admin->id}/role", ['role' => 'user'])
        ->assertSessionHas('error');

    expect($admin->fresh()->role)->toBe('admin');
});

test('admin can delete another user', function () {
    $admin = User::factory()->admin()->create();
    $user = User::factory()->create();

    $this->actingAs($admin)->delete("/admin/users/{$user->id}");

    $this->assertModelMissing($user);
});

test('admin cannot delete their own account from user management', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->delete("/admin/users/{$admin->id}")
        ->assertSessionHas('error');

    $this->assertModelExists($admin);
});

test('regular users cannot manage users', function () {
    $user = User::factory()->create();
    $target = User::factory()->create();

    $this->actingAs($user)->patch("/admin/users/{$target->id}/role", ['role' => 'admin'])->assertForbidden();
    $this->actingAs($user)->delete("/admin/users/{$target->id}")->assertForbidden();

    expect($target->fresh()->role)->toBe('user');
});

test('users can update their own profile', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->patch('/profile', ['name' => 'Nama Baru', 'email' => $user->email])
        ->assertSessionHasNoErrors();

    expect($user->fresh()->name)->toBe('Nama Baru');
});
