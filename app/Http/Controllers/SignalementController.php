<?php

namespace App\Http\Controllers;

use App\Models\Poste;
use App\Models\Signalement;
use App\Models\User;
use App\Models\CustomDatabaseNotification;
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

        // Notification manuelle à chaque technicien (sans UUID)
        foreach ($techniciens as $tech) {
           CustomDatabaseNotification::create([
    'notifiable_id' => $tech->id,
    'notifiable_type' => get_class($tech),
    'type' => \App\Notifications\PanneSignaléeNotification::class,
    'data' => [
        'code_poste' => $poste->code_poste,
        // 'zone' => $poste->zone->nom ?? 'Zone inconnue', ← supprime cette ligne
        'message' => $validated['message'],
        'url' => route('postes.show', $poste->id),
        'signalé_par' => 'Gestionnaire',
        'created_at' => now(),
    ],
    'created_at' => now(),
    'updated_at' => now(),
]);
        }

        return back()->with('success', 'Les techniciens ont été informés.');
    }
}