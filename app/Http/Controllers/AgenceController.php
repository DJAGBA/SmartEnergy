<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\Zone;
use Illuminate\Http\Request;

class AgenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agences = Agence::all();
        return view('agences.index', compact('agences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $zones = Zone::all(); // Ajouté pour éviter l'erreur
        return view('agences.create', compact('zones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            // Si tu veux valider une zone associée :
            // 'zone_id' => 'nullable|exists:zones,id',
        ]);

        Agence::create($request->only('nom', 'description'));

        return redirect()->route('agences.index')->with('success', 'Agence créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $agence = Agence::findOrFail($id);
        return view('agences.show', compact('agence'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $agence = Agence::findOrFail($id);
        $zones = Zone::all(); // Optionnel si tu veux modifier la zone associée
        return view('agences.edit', compact('agence', 'zones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $agence = Agence::findOrFail($id);
        $agence->update($request->only('nom', 'description'));

        return redirect()->route('agences.index')->with('success', 'Agence mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $agence = Agence::findOrFail($id);
        $agence->delete();

        return redirect()->route('agences.index')->with('success', 'Agence supprimée avec succès.');
    }
}