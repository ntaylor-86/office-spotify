<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\AccessToken;
use Illuminate\Support\Str;
use App\Models\PlaylistTrack;
use Illuminate\Console\Command;
use SpotifyWebAPI\SpotifyWebAPI;

class GetPlaylistTracks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spotify:get-playlist-tracks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stores all the tracks in the playlist into the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiTracks = [];

        $this->info('Calling the Spotify API.');
        $accessToken = AccessToken::first();
        $api = new SpotifyWebAPI();
        $api->setAccessToken($accessToken->accessToken);
        $playlistTracks = $api->getPlaylistTracks(env('SPOTIFY_PLAYLIST_ID'));

        $offset = 0;
        $total = $playlistTracks->total;

        // The Spotify API can only return 100 tracks per API call
        // Using the offset variable to call the next 100 tracks
        // until we get all the tracks in the playlist
        while ($offset < $total) {
            foreach ($playlistTracks->items as $key => $track) {
                $tmpObject = (object) [
                    'uri' => $track->track->uri,
                    'title' => $track->track->name,
                    'artist' => $track->track->artists[0]->name,
                    'album' => $track->track->album->name,
                    'explicit' => $track->track->explicit,
                    'added_at' => Carbon::parse($track->added_at)->setTimezone('Australia/Brisbane'),
                    'duration' => $track->track->duration_ms,
                ];
                array_push($apiTracks, $tmpObject);
            }

            if ( ($offset + 100) > $total ) {
                break;
            }

            $offset = $offset + 100;

            $playlistTracks = $api->getPlaylistTracks(
                env('SPOTIFY_PLAYLIST_ID'),
                ['offset' => $offset]
            );
        }

        $this->info('Loaded ' . count($apiTracks) . ' tracks from the Spotify API.');

        // Getting all the tracks from the PlaylistTrack model
        // then comparing it against the tracks from the API
        $allTracks = PlaylistTrack::get();

        foreach ($apiTracks as $apiTrack) {
            $track = $allTracks->where('uri', $apiTrack->uri)->first();

            if (is_null($track)) {
                // New track that has to be added to the model
                $this->info(
                    'Adding new track ' . $apiTrack->title . 
                    ' by ' . $apiTrack->artist . '.'
                );

                $playlistTrack = PlaylistTrack::create([
                    'uri' => $apiTrack->uri,
                    'title' => $apiTrack->title,
                    'artist' => $apiTrack->artist,
                    'album' => $apiTrack->album,
                    'explicit' => $apiTrack->explicit,
                    'added_at' => $apiTrack->added_at,
                    'duration' => $apiTrack->duration,
                ]);
                continue;
            }
        
            $track->updated_at = now();
            $track->save();
        }

        $this->info('Finished adding and updating all tracks in the playlist.');

        $oldTracks = PlaylistTrack::query()
                        ->where('updated_at', '<=', now()->subHour())
                        ->get();
        $this->info(
            'Found ' . count($oldTracks) . ' old ' .
            Str::plural('track', count($oldTracks)) .
            ' to remove.'
        );

        foreach ($oldTracks as $oldTrack) {
            $oldTrack->delete();
        }

        $this->info('Finished.');
    }
}
