<?php

namespace App\Http\Controllers;

use App\Models\League;
use Illuminate\Http\Request;

class LeagueController extends Controller
{
    public function index()
    {
        $leagues = League::with('teams')->get();
        return response()->json($leagues);
    }

    public function show($id)
    {
        $league = League::with(['teams', 'matches'])->findOrFail($id);
        return response()->json($league);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'logo' => 'nullable|string|max:255',
        ]);

        $league = League::create($validated);
        return response()->json($league, 201);
    }

    public function update(Request $request, $id)
    {
        $league = League::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'string|max:255',
            'country' => 'nullable|string|max:255',
            'logo' => 'nullable|string|max:255',
        ]);

        $league->update($validated);
        return response()->json($league);
    }

    public function destroy($id)
    {
        $league = League::findOrFail($id);
        $league->delete();
        return response()->json(null, 204);
    }
}
