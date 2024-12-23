<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpotifyController;
use App\Http\Controllers\TokenController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/get-token', [TokenController::class, 'index'])->name('get-token');
Route::get('/refresh-token', [TokenController::class, 'refreshToken'])->name('refresh-token');


Route::prefix('spotify')->name('spotify.')->group(function () {
    Route::get('/current-track', [SpotifyController::class, 'currentTrack'])
        ->name('current-track');
});


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
