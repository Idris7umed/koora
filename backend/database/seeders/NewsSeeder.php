<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $news = [
            [
                'title' => 'Manchester United Wins Against Liverpool',
                'content' => 'In a thrilling match at Old Trafford, Manchester United secured a 2-1 victory over Liverpool. The match showcased excellent performances from both teams.',
                'image' => 'https://via.placeholder.com/600x400',
                'author' => 'John Doe',
            ],
            [
                'title' => 'Real Madrid Defeats Barcelona in El Clasico',
                'content' => 'Real Madrid came out on top in the latest El Clasico, winning 3-2 at home. The match was filled with excitement and showcased the best of Spanish football.',
                'image' => 'https://via.placeholder.com/600x400',
                'author' => 'Jane Smith',
            ],
            [
                'title' => 'Transfer Window: Top Deals This Season',
                'content' => 'The transfer window has seen some major moves this season. From record-breaking deals to surprise transfers, clubs have been busy strengthening their squads.',
                'image' => 'https://via.placeholder.com/600x400',
                'author' => 'Mike Johnson',
            ],
            [
                'title' => 'Champions League Draw Announced',
                'content' => 'The Champions League draw has been completed, setting up some exciting matchups for the knockout stages. Fans are eagerly anticipating these high-stakes encounters.',
                'image' => 'https://via.placeholder.com/600x400',
                'author' => 'Sarah Williams',
            ],
        ];

        foreach ($news as $item) {
            \App\Models\News::create($item);
        }
    }
}
