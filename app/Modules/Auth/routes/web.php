<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Controllers\AdminDashboardController;
use Modules\Auth\Controllers\AuthController;
use Modules\Auth\Controllers\UserManagementController;

// Hanya untuk tamu (belum login)
Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

// Memerlukan login (middleware auth)
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Pintu masuk umum: arahkan ke dashboard sesuai role
    Route::get('/dashboard', function () {
        $user = request()->user();

        return redirect()->route($user->isAdmin() ? 'admin.dashboard' : 'user.dashboard');
    })->name('dashboard');

    Route::get('/user/dashboard', function () {
        return view('dashboard');
    })->name('user.dashboard');
});

// Memerlukan login + role admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Nilai plus: manajemen user
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/role', [UserManagementController::class, 'updateRole'])->name('users.role');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
});
