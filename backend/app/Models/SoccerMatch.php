<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoccerMatch extends Model
{
    protected $table = 'matches';
    
    protected $fillable = [
        'home_team_id', 'away_team_id', 'league_id',
        'home_score', 'away_score', 'match_date', 'status', 'venue'
    ];

    protected $casts = [
        'match_date' => 'datetime',
    ];

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }
}
