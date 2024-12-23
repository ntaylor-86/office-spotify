<?php

namespace App\Http\Controllers;

use SpotifyWebAPI\Session;
use Illuminate\Http\Request;
use SpotifyWebAPI\SpotifyWebAPI;

class TokenController extends Controller
{
    public $scopes = [
        'playlist-read-private',
        'playlist-read-collaborative',
        'playlist-modify-private',
        'playlist-modify-public',
        'user-read-private',
        'user-read-email',
        'user-read-playback-state'
    ];

    public function index()
    {
        $session = new Session(env('SPOTIFY_CLIENT_ID'),env('SPOTIFY_CLIENT_SECRET'), 'http://office-spotify.test/test');
        $api = new SpotifyWebAPI();

        if (isset($_GET['code'])) {
            $session->requestAccessToken($_GET['code']);
            $api->setAccessToken($session->getAccessToken());

            dd($session);
            dump($api->me());
        } else {
            $options = [
                'scope' => $this->scopes,
            ];

            header('Location: ' . $session->getAuthorizeUrl($options));
            die();
        }
    }
}
