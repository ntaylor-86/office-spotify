<?php
namespace App\Spotify;

use SpotifyWebAPI\SpotifyWebAPI;

class Spotify
{

    /**
     * GetCurrentTrack
     * 
     * @return array
     */
    public static function GetCurrentTrack(string $accessToken)
    {
        try {
            $api = new SpotifyWebAPI();
            $api->setAccessToken($accessToken);
            $currentTrack = $api->getMyCurrentTrack();

            if (is_null($currentTrack)) {
                return [
                    'data' => null
                ];
            }

            return [
                'data' => [
                    'uri' => $currentTrack->item->uri,
                    'artist' => $currentTrack->item->artists[0]->name,
                    'track' => $currentTrack->item->name,
                    'releaseDate' => $currentTrack->item->album->release_date,
                    'cover' => $currentTrack->item->album->images[0]->url
                ]
            ];
        } catch (\Throwable $th) {
            return [
                'error' => $th->getMessage()
            ];
        }

    }
}