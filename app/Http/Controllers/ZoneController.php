<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agence;
use App\Models\Zone;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $zones = Zone::with('agence')->get();
    return view('zones.index', compact('zones'));
}

 public function getZones($agenceId)
    {
        $zones = Zone::where('agence_id', $agenceId)->get(['id', 'nom']);
        return response()->json($zones);
    }

public function create()
{
    $agences = Agence::all(); // Si tu veux afficher les agences dans un <select>
    return view('zones.create', compact('agences'));
}

public function edit(Zone $zone)
{
    $agences = Agence::all();
    return view('zones.edit', compact('zone', 'agences'));
}

public function update(Request $request, Zone $zone)
{
    $zone->update($request->validate([
        'nom' => 'required|string',
        'description' => 'nullable|string',
        'agence_id' => 'required|exists:agences,id',
    ]));

    return redirect()->route('zones.index')->with('success', 'Zone mise à jour.');
}

public function destroy(Zone $zone)
{
    $zone->delete();
    return redirect()->route('zones.index')->with('success', 'Zone supprimée.');
}

public function getPostes(Zone $zone)
{
    $postes = $zone->postes()->select('postes.id', 'postes.code_poste')->get();
    return response()->json($postes);
}
}
