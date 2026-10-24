<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// User dapat mengupdate profil sendiri
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route login/register/logout + dashboard ada di Modules/Auth/routes/web.php.
// File ini hanya memuat sisa fitur Breeze (reset password, verifikasi email, dll).
require __DIR__.'/auth.php';
