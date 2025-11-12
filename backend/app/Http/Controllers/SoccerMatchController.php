<?php

namespace App\Http\Controllers;

use App\Models\SoccerMatch;
use Illuminate\Http\Request;

class SoccerMatchController extends Controller
{
    public function index(Request $request)
    {
        $query = SoccerMatch::with(['homeTeam', 'awayTeam', 'league']);
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('league_id')) {
            $query->where('league_id', $request->league_id);
        }
        
        $matches = $query->orderBy('match_date', 'desc')->get();
        return response()->json($matches);
    }

    public function upcoming()
    {
        $matches = SoccerMatch::with(['homeTeam', 'awayTeam', 'league'])
            ->where('status', 'upcoming')
            ->where('match_date', '>', now())
            ->orderBy('match_date', 'asc')
            ->get();
        
        return response()->json($matches);
    }

    public function live()
    {
        $matches = SoccerMatch::with(['homeTeam', 'awayTeam', 'league'])
            ->where('status', 'live')
            ->get();
        
        return response()->json($matches);
    }

    public function results()
    {
        $matches = SoccerMatch::with(['homeTeam', 'awayTeam', 'league'])
            ->where('status', 'finished')
            ->orderBy('match_date', 'desc')
            ->get();
        
        return response()->json($matches);
    }

    public function show($id)
    {
        $match = SoccerMatch::with(['homeTeam', 'awayTeam', 'league'])->findOrFail($id);
        return response()->json($match);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id',
            'league_id' => 'required|exists:leagues,id',
            'home_score' => 'nullable|integer',
            'away_score' => 'nullable|integer',
            'match_date' => 'required|date',
            'status' => 'required|in:upcoming,live,finished',
            'venue' => 'nullable|string|max:255',
        ]);

        $match = SoccerMatch::create($validated);
        return response()->json($match->load(['homeTeam', 'awayTeam', 'league']), 201);
    }

    public function update(Request $request, $id)
    {
        $match = SoccerMatch::findOrFail($id);
        
        $validated = $request->validate([
            'home_team_id' => 'exists:teams,id',
            'away_team_id' => 'exists:teams,id',
            'league_id' => 'exists:leagues,id',
            'home_score' => 'nullable|integer',
            'away_score' => 'nullable|integer',
            'match_date' => 'date',
            'status' => 'in:upcoming,live,finished',
            'venue' => 'nullable|string|max:255',
        ]);

        $match->update($validated);
        return response()->json($match->load(['homeTeam', 'awayTeam', 'league']));
    }

    public function destroy($id)
    {
        $match = SoccerMatch::findOrFail($id);
        $match->delete();
        return response()->json(null, 204);
    }
}
