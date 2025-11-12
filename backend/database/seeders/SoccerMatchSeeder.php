<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SoccerMatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $matches = [
            // Finished matches
            [
                'home_team_id' => 1,
                'away_team_id' => 2,
                'league_id' => 1,
                'home_score' => 2,
                'away_score' => 1,
                'match_date' => now()->subDays(3),
                'status' => 'finished',
                'venue' => 'Old Trafford'
            ],
            [
                'home_team_id' => 5,
                'away_team_id' => 6,
                'league_id' => 2,
                'home_score' => 3,
                'away_score' => 2,
                'match_date' => now()->subDays(2),
                'status' => 'finished',
                'venue' => 'Santiago Bernabéu'
            ],
            
            // Live match
            [
                'home_team_id' => 3,
                'away_team_id' => 4,
                'league_id' => 1,
                'home_score' => 1,
                'away_score' => 0,
                'match_date' => now(),
                'status' => 'live',
                'venue' => 'Stamford Bridge'
            ],
            
            // Upcoming matches
            [
                'home_team_id' => 2,
                'away_team_id' => 3,
                'league_id' => 1,
                'home_score' => null,
                'away_score' => null,
                'match_date' => now()->addDays(2),
                'status' => 'upcoming',
                'venue' => 'Anfield'
            ],
            [
                'home_team_id' => 6,
                'away_team_id' => 7,
                'league_id' => 2,
                'home_score' => null,
                'away_score' => null,
                'match_date' => now()->addDays(3),
                'status' => 'upcoming',
                'venue' => 'Camp Nou'
            ],
        ];

        foreach ($matches as $match) {
            \App\Models\SoccerMatch::create($match);
        }
    }
}
