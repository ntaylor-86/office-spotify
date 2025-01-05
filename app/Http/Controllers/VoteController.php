<?php

namespace App\Http\Controllers;

use App\Models\PlaylistTrack;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VoteController extends Controller
{
    /**
     * Vote for a Track in the Playlist
     * 
     */
    public function vote(Request $request)
    {
        $validated = $request->validate([
            'voteType' => 'required',
            'uri' => 'required',
            'albumImage' => 'required'
        ]);

        $track = PlaylistTrack::query()
                    ->where('uri', $request->uri)
                    ->first();

        // Track does not exist in the Playlist
        if (is_null($track)) {
            return Inertia::render('Voted', [
                'track' => null,
                'albumImage' => null
            ]);
        }

        // Adding the vote to the track
        if ($request->voteType === 1) {
            $track->up_votes = $track->up_votes + 1;
        } else {
            $track->down_votes = $track->down_votes + 1;
        }
        $track->save();

        return Inertia::render('Voted', [
            'track' => $track,
            'voteType' => $request->voteType,
            'albumImage' => $request-> albumImage
        ]);
    }
}
