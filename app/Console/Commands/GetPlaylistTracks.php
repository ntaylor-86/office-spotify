<?php

namespace App\Console\Commands;

use App\Models\AccessToken;
use App\Models\PlaylistTrack;
use Carbon\Carbon;
use Illuminate\Console\Command;
use SpotifyWebAPI\SpotifyWebAPI;

class GetPlaylistTracks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-playlist-tracks';

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
        $accessToken = AccessToken::first();
        $api = new SpotifyWebAPI();
        $api->setAccessToken($accessToken->accessToken);
        $playlistTracks = $api->getPlaylistTracks(env('SPOTIFY_PLAYLIST_ID'));

        $offset = 0;
        $total = $playlistTracks->total;

        while ($offset < $total) {
            dump($playlistTracks->next);

            foreach ($playlistTracks->items as $key => $track) {
                $playlistTrack = PlaylistTrack::create([
                    'uri' => $track->track->uri,
                    'title' => $track->track->name,
                    'artist' => $track->track->artists[0]->name,
                    'album' => $track->track->album->name,
                    'explicit' => $track->track->explicit,
                    'added_at' => Carbon::parse($track->added_at)->setTimezone('Australia/Brisbane'),
                    'duration' => $track->track->duration_ms,
                ]);
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

    }
}
