<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name', 'league_id', 'logo', 'stadium'];

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function homeMatches()
    {
        return $this->hasMany(SoccerMatch::class, 'home_team_id');
    }

    public function awayMatches()
    {
        return $this->hasMany(SoccerMatch::class, 'away_team_id');
    }
}
