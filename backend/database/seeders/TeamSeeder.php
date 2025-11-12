<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            // Premier League teams
            ['name' => 'Manchester United', 'league_id' => 1, 'logo' => 'https://via.placeholder.com/100', 'stadium' => 'Old Trafford'],
            ['name' => 'Liverpool', 'league_id' => 1, 'logo' => 'https://via.placeholder.com/100', 'stadium' => 'Anfield'],
            ['name' => 'Chelsea', 'league_id' => 1, 'logo' => 'https://via.placeholder.com/100', 'stadium' => 'Stamford Bridge'],
            ['name' => 'Arsenal', 'league_id' => 1, 'logo' => 'https://via.placeholder.com/100', 'stadium' => 'Emirates Stadium'],
            
            // La Liga teams
            ['name' => 'Real Madrid', 'league_id' => 2, 'logo' => 'https://via.placeholder.com/100', 'stadium' => 'Santiago Bernabéu'],
            ['name' => 'Barcelona', 'league_id' => 2, 'logo' => 'https://via.placeholder.com/100', 'stadium' => 'Camp Nou'],
            ['name' => 'Atletico Madrid', 'league_id' => 2, 'logo' => 'https://via.placeholder.com/100', 'stadium' => 'Wanda Metropolitano'],
            ['name' => 'Sevilla', 'league_id' => 2, 'logo' => 'https://via.placeholder.com/100', 'stadium' => 'Ramón Sánchez Pizjuán'],
        ];

        foreach ($teams as $team) {
            \App\Models\Team::create($team);
        }
    }
}
