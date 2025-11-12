<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\League;
use App\Models\Team;
use App\Models\SoccerMatch;

class ApiFootballController extends Controller
{
    private $apiKey;
    private $apiHost = 'api-football-v1.p.rapidapi.com';
    private $baseUrl = 'https://api-football-v1.p.rapidapi.com/v3';

    public function __construct()
    {
        $this->apiKey = env('FOOTBALL_API_KEY', '');
    }

    /**
     * Fetch leagues from external API and save to database
     */
    public function fetchLeagues(Request $request)
    {
        try {
            // For demo purposes, we'll use a free alternative API or provide mock data
            // API-Football requires RapidAPI key, so we provide a fallback
            
            if (empty($this->apiKey)) {
                return response()->json([
                    'message' => 'Please set FOOTBALL_API_KEY in .env file to use external API',
                    'info' => 'You can get a free API key from https://rapidapi.com/api-sports/api/api-football',
                    'fallback' => 'Using sample data from database'
                ], 200);
            }

            $response = Http::withHeaders([
                'X-RapidAPI-Key' => $this->apiKey,
                'X-RapidAPI-Host' => $this->apiHost
            ])->get($this->baseUrl . '/leagues');

            if ($response->successful()) {
                $leagues = $response->json()['response'];
                
                foreach ($leagues as $leagueData) {
                    League::updateOrCreate(
                        ['name' => $leagueData['league']['name']],
                        [
                            'country' => $leagueData['country']['name'] ?? null,
                            'logo' => $leagueData['league']['logo'] ?? null,
                        ]
                    );
                }

                return response()->json([
                    'message' => 'Leagues fetched successfully',
                    'count' => count($leagues)
                ]);
            }

            return response()->json(['error' => 'Failed to fetch leagues'], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'API request failed',
                'message' => $e->getMessage(),
                'info' => 'Make sure you have a valid FOOTBALL_API_KEY in .env'
            ], 500);
        }
    }

    /**
     * Fetch teams from external API and save to database
     */
    public function fetchTeams(Request $request)
    {
        $leagueId = $request->input('league_id');
        $season = $request->input('season', date('Y'));

        try {
            if (empty($this->apiKey)) {
                return response()->json([
                    'message' => 'Please set FOOTBALL_API_KEY in .env file to use external API',
                    'info' => 'You can get a free API key from https://rapidapi.com/api-sports/api/api-football',
                    'fallback' => 'Using sample data from database'
                ], 200);
            }

            $response = Http::withHeaders([
                'X-RapidAPI-Key' => $this->apiKey,
                'X-RapidAPI-Host' => $this->apiHost
            ])->get($this->baseUrl . '/teams', [
                'league' => $leagueId,
                'season' => $season
            ]);

            if ($response->successful()) {
                $teams = $response->json()['response'];
                
                foreach ($teams as $teamData) {
                    Team::updateOrCreate(
                        ['name' => $teamData['team']['name']],
                        [
                            'league_id' => $request->input('db_league_id', 1),
                            'logo' => $teamData['team']['logo'] ?? null,
                            'stadium' => $teamData['venue']['name'] ?? null,
                        ]
                    );
                }

                return response()->json([
                    'message' => 'Teams fetched successfully',
                    'count' => count($teams)
                ]);
            }

            return response()->json(['error' => 'Failed to fetch teams'], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'API request failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Fetch matches from external API and save to database
     */
    public function fetchMatches(Request $request)
    {
        $leagueId = $request->input('league_id');
        $season = $request->input('season', date('Y'));

        try {
            if (empty($this->apiKey)) {
                return response()->json([
                    'message' => 'Please set FOOTBALL_API_KEY in .env file to use external API',
                    'info' => 'You can get a free API key from https://rapidapi.com/api-sports/api/api-football',
                    'fallback' => 'Using sample data from database'
                ], 200);
            }

            $response = Http::withHeaders([
                'X-RapidAPI-Key' => $this->apiKey,
                'X-RapidAPI-Host' => $this->apiHost
            ])->get($this->baseUrl . '/fixtures', [
                'league' => $leagueId,
                'season' => $season
            ]);

            if ($response->successful()) {
                $fixtures = $response->json()['response'];
                
                foreach ($fixtures as $fixture) {
                    $homeTeam = Team::where('name', $fixture['teams']['home']['name'])->first();
                    $awayTeam = Team::where('name', $fixture['teams']['away']['name'])->first();

                    if ($homeTeam && $awayTeam) {
                        $status = 'upcoming';
                        if ($fixture['fixture']['status']['short'] == 'FT') {
                            $status = 'finished';
                        } elseif (in_array($fixture['fixture']['status']['short'], ['1H', '2H', 'HT', 'ET', 'P'])) {
                            $status = 'live';
                        }

                        SoccerMatch::updateOrCreate(
                            [
                                'home_team_id' => $homeTeam->id,
                                'away_team_id' => $awayTeam->id,
                                'match_date' => $fixture['fixture']['date']
                            ],
                            [
                                'league_id' => $request->input('db_league_id', 1),
                                'home_score' => $fixture['goals']['home'],
                                'away_score' => $fixture['goals']['away'],
                                'status' => $status,
                                'venue' => $fixture['fixture']['venue']['name'] ?? null,
                            ]
                        );
                    }
                }

                return response()->json([
                    'message' => 'Matches fetched successfully',
                    'count' => count($fixtures)
                ]);
            }

            return response()->json(['error' => 'Failed to fetch matches'], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'API request failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get API info and instructions
     */
    public function info()
    {
        return response()->json([
            'api_configured' => !empty($this->apiKey),
            'message' => 'To fetch real data from API-Football:',
            'steps' => [
                '1. Sign up for a free account at https://rapidapi.com/api-sports/api/api-football',
                '2. Subscribe to the free tier (500 requests/day)',
                '3. Copy your RapidAPI key',
                '4. Add FOOTBALL_API_KEY=your_key_here to backend/.env file',
                '5. Use the following endpoints to import data:',
            ],
            'endpoints' => [
                'POST /api/external/fetch-leagues' => 'Fetch and import leagues',
                'POST /api/external/fetch-teams?league_id=39&season=2024&db_league_id=1' => 'Fetch teams for a league',
                'POST /api/external/fetch-matches?league_id=39&season=2024&db_league_id=1' => 'Fetch matches for a league',
            ],
            'note' => 'If no API key is configured, the system will use the sample data already seeded in the database.'
        ]);
    }
}
