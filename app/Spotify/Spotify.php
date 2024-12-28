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

            // dd($currentTrack);

            if (is_null($currentTrack)) {
                return [
                    'data' => null
                ];
            }

            // Getting the release year from the Spotify API
            $regex = "/\d{4}/";
            $releaseDate = $currentTrack->item->album->release_date;
            if (preg_match($regex, $releaseDate, $matches) > 0) {
                $releaseDate = $matches[0];
            }

            // Working out the progress of the track from the Spofity API
            $totalLength = $currentTrack->item->duration_ms;
            $progress = $currentTrack->progress_ms;
            $progressPercentage = round( ( ($progress * 100) / $totalLength ), 2 );

            return [
                'data' => [
                    'uri' => $currentTrack->item->uri,
                    'artist' => $currentTrack->item->artists[0]->name,
                    'track' => $currentTrack->item->name,
                    'releaseDate' => $releaseDate,
                    'cover' => $currentTrack->item->album->images[0]->url,
                    'isPlaying' => $currentTrack->is_playing,
                    'progress' => $progressPercentage
                ]
            ];
        } catch (\Throwable $th) {
            return [
                'error' => $th->getMessage()
            ];
        }

    }
}