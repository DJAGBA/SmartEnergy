<?php

namespace App\Http\Controllers;

use App\Models\Poste;
use App\Models\Signalement;
use App\Models\User;
use App\Notifications\PanneSignaléeNotification;
use Illuminate\Http\Request;

class SignalementController extends Controller
{
    /**
     * Enregistre un signalement et notifie les techniciens.
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $validated = $request->validate([
            'poste_id' => 'required|exists:postes,id',
            'message' => 'nullable|string|max:1000',
        ]);

        // Récupération du poste concerné
        $poste = Poste::findOrFail($validated['poste_id']);

        // Création du signalement
        $signalement = Signalement::create([
            'poste_id' => $poste->id,
            'gestionnaire_id' => auth()->id(),
            'message' => $validated['message'],
            'etat' => 'non_traite',
        ]);

        // Récupération des techniciens
        $techniciens = User::where('role', 'technicien')->get();

        // Notification à chaque technicien
        foreach ($techniciens as $tech) {
            $tech->notify(new PanneSignaléeNotification(
                "Le poste {$poste->code_poste} a été signalé comme problématique. Message : {$validated['message']}",
                $poste->id
            ));
        }

        return back()->with('success', 'Les techniciens ont été informés.');
    }
}