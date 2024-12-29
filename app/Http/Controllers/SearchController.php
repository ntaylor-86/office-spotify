<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Request;

use App\Models\AccessToken;
use Inertia\Inertia;
use Illuminate\Http\Request;

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


    }
}
