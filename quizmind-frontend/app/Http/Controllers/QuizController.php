<?php
// app/Http/Controllers/QuizController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    // URL du serveur Java
    private string $javaApi = 'http://localhost:8080/api';

    public function home()
    {
        $domains = [
            ['name' => 'Science',         'emoji' => '🔬'],
            ['name' => 'Histoire',         'emoji' => '🏛️'],
            ['name' => 'Géographie',       'emoji' => '🌍'],
            ['name' => 'Technologie',      'emoji' => '💻'],
            ['name' => 'Cinéma',           'emoji' => '🎬'],
            ['name' => 'Sport',            'emoji' => '⚽'],
            ['name' => 'Musique',          'emoji' => '🎵'],
            ['name' => 'Culture Générale', 'emoji' => '🎓'],
        ];
        return view('home', compact('domains'));
    }

    public function quiz(Request $request)
    {
        $domain     = $request->query('domain', 'Science');
        $difficulty = $request->query('difficulty', 'facile');
        $total      = $request->query('total', 10);
        $player     = $request->query('player', 'Joueur');

        return view('quiz', compact('domain', 'difficulty', 'total', 'player'));
    }

    public function result(Request $request)
    {
        $data = $request->all(); // correct, wrong, score, analysis...
        return view('result', compact('data'));
    }

    public function leaderboard(Request $request)
    {
        $domain = $request->query('domain', '');
        // Appel API Java
        $url = $this->javaApi . '/leaderboard?domain=' . urlencode($domain);
        $response = file_get_contents($url);
        $scores = json_decode($response, true);
        return view('leaderboard', compact('scores', 'domain'));
    }
}
