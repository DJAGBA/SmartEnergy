<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poste;
use App\Models\Client;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function migrationExecute(Request $request, Poste $source_poste)
{
    $request->validate([
        'destination_poste_id' => 'required|exists:postes,id',
    ]);

    $destinationPosteId = $request->input('destination_poste_id');

    // Migration des clients
    Client::where('poste_id', $source_poste->id)
        ->update(['poste_id' => $destinationPosteId]);

    return redirect()->route('postes.index')->with('success', 'Les clients ont été migrés avec succès.');
}
}
