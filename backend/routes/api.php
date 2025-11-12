<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\SoccerMatchController;
use App\Http\Controllers\NewsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Leagues
Route::apiResource('leagues', LeagueController::class);

// Teams
Route::apiResource('teams', TeamController::class);

// Matches
Route::apiResource('matches', SoccerMatchController::class);
Route::get('matches/upcoming/list', [SoccerMatchController::class, 'upcoming']);
Route::get('matches/live/list', [SoccerMatchController::class, 'live']);
Route::get('matches/results/list', [SoccerMatchController::class, 'results']);

// News
Route::apiResource('news', NewsController::class);
