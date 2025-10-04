<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\PosteProblemeNotification;

public function  store(Request $request)
{
    $validated = $request->validate([
        'poste_id' => 'required|exists:postes,id',
        'message' => 'nullable|string|max:1000',
    ]);

    $signalement = Signalement::create([
        'poste_id' => $validated['poste_id'],
        'gestionnaire_id' => auth()->id(),
        'message' => $validated['message'],
        'etat' => 'non_traite',
    ]);

    // Exemple : notifier tous les techniciens
    $techniciens = User::where('role', 'technicien')->get();

    foreach ($techniciens as $tech) {
        $tech->notify(new PosteProblemeNotification("Poste {$signalement->poste->code} signalé comme problématique."));
    }

    return back()->with('success', 'Le technicien a été informé.');
}