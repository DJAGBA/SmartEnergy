<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Poste;
use App\Models\Zone;
use App\Models\Coupure;
use App\Models\Feedback;
use App\Models\User;

class PortailController extends Controller
{
    /**
     * Affiche le portail client avec les coupures à venir
     */
    public function index(): \Illuminate\View\View
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $coupures = Coupure::with(['zones', 'postes'])
            ->orderByDesc('date_debut')
            ->get();

        return view('portail.index', compact('user', 'coupures'));
    }

    /**
     * Recherche de coupures par référence client
     */
    public function recherche(Request $request)
{
    $client = Client::where('reference', $request->reference)
        ->with('zone.coupures')
        ->first();

    if (!$client || !$client->zone) {
        return back()->with('error', 'Client ou zone introuvable');
    }

    $coupures = $client->zone->coupures;

    return view('portail.recherche-resultats', compact('client', 'coupures'));
}

    /**
     * Mise à jour de l'abonnement client
     */
    public function updateAbonnement(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'abonnement' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $user->abonnement = $request->abonnement;
        $user->save();

        return back()->with('success', 'Abonnement mis à jour.');
    }

    /**
     * Enregistrement d’un retour client
     */
    public function storeFeedback(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return back()->with('success', 'Merci pour votre retour.');
    }

    /**
     * Affiche une coupure spécifique
     */
    public function show(int $id): \Illuminate\View\View
    {
        $coupure = Coupure::findOrFail($id);
        return view('portail.coupure', compact('coupure'));
    }
}