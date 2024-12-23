<?php

namespace App\Http\Controllers;

use App\Models\AccessToken;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home');

        $accessToken = AccessToken::first();

        if (is_null($accessToken)) {
            return redirect(route('get-token'));
        }

    }
}
