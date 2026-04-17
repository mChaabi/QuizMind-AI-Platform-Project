<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;

Route::get('/',              [QuizController::class, 'home']);
Route::get('/quiz',          [QuizController::class, 'quiz']);
Route::get('/result',        [QuizController::class, 'result']);
Route::get('/leaderboard',   [QuizController::class, 'leaderboard']);

