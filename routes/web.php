<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SpotifyController;
use App\Http\Controllers\TokenController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

// Home

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

// Token

Route::get('/token', [TokenController::class, 'index'])
    ->name('token.index');

Route::get('/token/get', [TokenController::class, 'tokenGet'])
    ->name('token.get');

Route::get('/token/refresh', [TokenController::class, 'tokenRefresh'])
    ->name('token.refresh');

// Search

Route::get('/search', [SearchController::class, 'index'])
    ->name('search.index');

Route::post('/search/add-to-playlist', [SearchController::class, 'addToPlaylist'])
    ->name('search.add-to-playlist');


// Route::prefix('spotify')->name('spotify.')->group(function () {
//     Route::get('/current-track', [SpotifyController::class, 'currentTrack'])
//         ->name('current-track');
// });


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
