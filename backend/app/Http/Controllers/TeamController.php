<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with('league')->get();
        return response()->json($teams);
    }

    public function show($id)
    {
        $team = Team::with(['league', 'homeMatches', 'awayMatches'])->findOrFail($id);
        return response()->json($team);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'league_id' => 'required|exists:leagues,id',
            'logo' => 'nullable|string|max:255',
            'stadium' => 'nullable|string|max:255',
        ]);

        $team = Team::create($validated);
        return response()->json($team->load('league'), 201);
    }

    public function update(Request $request, $id)
    {
        $team = Team::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'string|max:255',
            'league_id' => 'exists:leagues,id',
            'logo' => 'nullable|string|max:255',
            'stadium' => 'nullable|string|max:255',
        ]);

        $team->update($validated);
        return response()->json($team->load('league'));
    }

    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();
        return response()->json(null, 204);
    }
}
