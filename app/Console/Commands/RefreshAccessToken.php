<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use SpotifyWebAPI\Session;
use App\Models\AccessToken;
use Illuminate\Console\Command;

class RefreshAccessToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spotify:refresh-access-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the Spotiy API Access Token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $accessToken = AccessToken::first();

        if (is_null($accessToken)) {
            return;
        }

        // Checking if the token is expiring in 5 minutes
        if (! $accessToken->expirationTime->lessThan(now()->addMinutes(5))) {
            $this->info(
                'Token is expiring in ' . 
                $accessToken->expirationTime->diffForHumans() . ', ' . 
                'not going to refresh yet.'
            );
            return;
        }

        $this->info(
            'Token is expiring in ' . 
            $accessToken->expirationTime->diffForHumans() . '.'
        );
        $this->info('Refresing Access Token now.');

        // Refreshing Access Token
        $session = new Session(
            clientId: env('SPOTIFY_CLIENT_ID'),
            clientSecret: env('SPOTIFY_CLIENT_SECRET'),
            redirectUri: route('token.get')
        );
        $session->refreshAccessToken($accessToken->refreshToken);

        // Updating the AccessToken model
        $accessToken->accessToken = $session->getAccessToken();
        $accessToken->refreshToken = $session->getRefreshToken();
        $expirationTime = Carbon::parse($session->getTokenExpiration())->setTimezone('Australia/Brisbane');
        $accessToken->expirationTime = $expirationTime;
        $accessToken->save();

        $this->info('Access Token successfully refreshed with the Spotify API.');
    }
}
