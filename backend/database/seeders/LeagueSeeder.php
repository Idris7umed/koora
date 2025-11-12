<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeagueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leagues = [
            ['name' => 'Premier League', 'country' => 'England', 'logo' => 'https://via.placeholder.com/100'],
            ['name' => 'La Liga', 'country' => 'Spain', 'logo' => 'https://via.placeholder.com/100'],
            ['name' => 'Serie A', 'country' => 'Italy', 'logo' => 'https://via.placeholder.com/100'],
            ['name' => 'Bundesliga', 'country' => 'Germany', 'logo' => 'https://via.placeholder.com/100'],
            ['name' => 'Ligue 1', 'country' => 'France', 'logo' => 'https://via.placeholder.com/100'],
        ];

        foreach ($leagues as $league) {
            \App\Models\League::create($league);
        }
    }
}
