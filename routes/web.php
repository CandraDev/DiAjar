<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\GoogleAuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman default
Route::get('/', function () {
    return view('welcome');
});

// Route dari Breeze (bawaan)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/testing', function () {
    // bikin user dummy (kalau belum ada)
    $user = User::firstOrCreate(
        ['email' => 'test@example.com'],
        [
            'name' => 'Test User',
            'password' => bcrypt('password123'), // kasih password biar realistis
        ]
    );

    // login pakai Auth
    Auth::login($user, true);

    // cek apakah ke-save ke session
    dd([
        'auth_user_now' => Auth::user(),
        'session_id'    => session()->getId(),
    ]);
});

Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

// ini bawaan Breeze (auth routes: login, register, forgot password, dll)
require __DIR__ . '/auth.php';
