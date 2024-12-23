<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TokenController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/get-token', [TokenController::class, 'index'])->name('get-token');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/test', function () {
    $session = new Session(env('SPOTIFY_CLIENT_ID'),env('SPOTIFY_CLIENT_SECRET'), 'http://office-spotify.test/test');
    $api = new SpotifyWebAPI();

    if (isset($_GET['code'])) {
        $session->requestAccessToken($_GET['code']);
        $api->setAccessToken($session->getAccessToken());

        dd($session);
        dump($api->me());
    } else {
        $options = [
            'scope' => [
                'user-read-email'
            ],
        ];

        header('Location: ' . $session->getAuthorizeUrl($options));
        die();
    }
    
});

require __DIR__.'/auth.php';
