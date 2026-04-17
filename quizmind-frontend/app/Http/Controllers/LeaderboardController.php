<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index()
    {
        // On définit les variables si nécessaire, sinon on retourne juste la vue
        return view('leaderboard');
    }
}
