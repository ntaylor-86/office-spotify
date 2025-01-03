<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Request;

use App\Models\AccessToken;
use App\Models\PlaylistTrack;
use Inertia\Inertia;
use Illuminate\Http\Request;
use SpotifyWebAPI\SpotifyWebAPI;

class SearchController extends Controller
{
    /**
     * Index
     * 
     */
    public function index(Request $request)
    {
        $results = [];

        if (! $request->has('value')) {
            return Inertia::render('Search', [
                'results' => $results
            ]);
        }

        // Getting the search string from the request
        $searchString = $request->value;

        $accessToken = AccessToken::first();

        // Checking if an AccessToken exists
        if (is_null($accessToken)) {
            return redirect()->route('token.index');
        }

        // Checking if the AccessToken is expired
        if ($accessToken->expirationTime->lessThan(now())) {
            return redirect()->route('token.refresh');
        }

        $api = new SpotifyWebAPI();
        $api->setAccessToken($accessToken->accessToken);
        $options = ['limit' => 10];
        $results = $api->search($searchString,'track', $options);
        // dd($results);

        return Inertia::render('Search', [
            'results' => $results->tracks->items
        ]);
    }

    /**
     * Add To Playlist
     * 
     */
    public function addToPlaylist(Request $request)
    {
        $validated = $request->validate([
            'uri' => 'required',
            'artist' => 'required',
            'trackName' => 'required',
            'albumImage' => 'required'
        ]);

        $response = [
            'songAdded' => false,
            'uri' => $request->uri,
            'artist' => $request->artist,
            'trackName' => $request->trackName,
            'albumImage' => $request->albumImage
        ];

        // First seeing if the song already
        // exists in the playlist
        $trackExists = PlaylistTrack::query()
                            ->where('uri', $request->uri)
                            ->exists();

        if ($trackExists) {
            return Inertia::render('SongAddedToPlaylist', [
                'response' => $response
            ]);
        }

        // If the track does not already exist in the
        // playlist, adding song to the playlist
        $accessToken = AccessToken::first();
        $api = new SpotifyWebAPI();
        $api->setAccessToken($accessToken->accessToken);
        $api->addPlaylistTracks(env('SPOTIFY_PLAYLIST_ID'), [
            $request->uri
        ]);

        $response['songAdded'] = true;
        return Inertia::render('SongAddedToPlaylist', [
            'response' => $response
        ]);
    }
}
