<?php

namespace App\Http\Controllers;

use App\Models\AccessToken;
use App\Spotify\Spotify;
use Illuminate\Http\Request;
use SpotifyWebAPI\SpotifyWebAPI;

class SpotifyController extends Controller
{
    public function currentTrack()
    {
        $accessToken = AccessToken::firstOrFail();

        $currentTrack = Spotify::GetCurrentTrack($accessToken->accessToken);

        return response()->json($currentTrack);
    }
}
