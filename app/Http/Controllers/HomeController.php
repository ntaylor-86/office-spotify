<?php

namespace App\Http\Controllers;

use App\Models\AccessToken;
use App\Spotify\Spotify;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * index
     * 
     */
    public function index()
    {
        $accessToken = AccessToken::first();

        // Checking if an AccessToken exists
        if (is_null($accessToken)) {
            return redirect()->route('get-token');
        }

        // Checking if the AccessToken is expired
        if ($accessToken->expirationTime->lessThan(now())) {
            return redirect()->route('refresh-token');
        }

        $currentTrack = Spotify::GetCurrentTrack($accessToken->accessToken);

        return Inertia::render('Home', [
            'currentTrack' => $currentTrack['data']
        ]);
    }
}
