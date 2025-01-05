<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\VoteController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// Vote for track

Route::post('/track/vote', [VoteController::class, 'vote'])
    ->name('track.vote');



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
