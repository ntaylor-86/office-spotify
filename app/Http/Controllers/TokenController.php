<?php

namespace App\Http\Controllers;

use App\Models\AccessToken;
use Carbon\Carbon;
use SpotifyWebAPI\Session;
use Illuminate\Http\Request;
use Inertia\Inertia;
use SpotifyWebAPI\SpotifyWebAPI;

class TokenController extends Controller
{
    /**
     * scopes
     * 
     * @var array
     */
    public $scopes = [
        'playlist-read-private',
        'playlist-read-collaborative',
        'playlist-modify-private',
        'playlist-modify-public',
        'user-read-private',
        'user-read-email',
        'user-read-playback-state'
    ];

    /**
     * Index
     * 
     */
    public function index()
    {
        return Inertia::render('TokenIndex');
    }

    /**
     * Token Get
     * 
     */
    public function tokenGet()
    {
        $session = new Session(
            clientId: env('SPOTIFY_CLIENT_ID'),
            clientSecret: env('SPOTIFY_CLIENT_SECRET'),
            redirectUri: route('token.get')
        );
        $api = new SpotifyWebAPI();

        if (isset($_GET['code'])) {
            $session->requestAccessToken($_GET['code']);
            $api->setAccessToken($session->getAccessToken());

            // dd($session);
            // dump($api->me());
            $accessToken = new AccessToken();
            $accessToken->accessToken = $session->getAccessToken();
            $expirationTime = Carbon::parse($session->getTokenExpiration())->setTimezone('Australia/Brisbane');
            $accessToken->expirationTime = $expirationTime;
            $accessToken->redirectUri = $session->getRedirectUri();
            $accessToken->refreshToken = $session->getRefreshToken();
            $accessToken->scope = implode(',', $session->getScope());
            $accessToken->save();

            return redirect()->route('home');
        } else {
            $options = [
                'scope' => $this->scopes,
            ];

            header('Location: ' . $session->getAuthorizeUrl($options));
            die();
        }
    }

    /**
     * Token Refresh
     * 
     */
    public function tokenRefresh()
    {
        $accessToken = AccessToken::first();

        $session = new Session(
            clientId: env('SPOTIFY_CLIENT_ID'),
            clientSecret: env('SPOTIFY_CLIENT_SECRET'),
            redirectUri: route('token.get')
        );
        $session->refreshAccessToken($accessToken->refreshToken);

        // dd($session);

        $accessToken->accessToken = $session->getAccessToken();
        $accessToken->refreshToken = $session->getRefreshToken();
        $expirationTime = Carbon::parse($session->getTokenExpiration())->setTimezone('Australia/Brisbane');
        $accessToken->expirationTime = $expirationTime;
        $accessToken->save();

        return redirect()->route('home');
    }
}
