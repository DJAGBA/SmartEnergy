<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortailController extends Controller
{
   public function index()
{
    $user = auth()->user();
    $coupures = \App\Models\Coupure::where('zone_id', $user->zone_id)
        ->where('date_fin', '>', now())
        ->orderBy('date_debut')
        ->get();

    return view('portail.index', compact('user', 'coupures'));
}

public function search(Request $request)
{
    $query = $request->motif;
    $user = auth()->user();

    $coupures = \App\Models\Coupure::where('zone_id', $user->zone_id)
        ->where(function ($q) use ($query) {
            $q->where('motif', 'like', "%$query%")
              ->orWhereHas('zone', fn($z) => $z->where('nom', 'like', "%$query%"));
        })
        ->get();

    return view('portail.index', compact('user', 'coupures'));
}

public function updateAbonnement(Request $request)
{
    $request->validate(['abonnement' => 'required']);
    $user = auth()->user();
    $user->abonnement = $request->abonnement;
    $user->save();

    return back()->with('success', 'Abonnement mis à jour.');
}

public function storeFeedback(Request $request)
{
    $request->validate(['message' => 'required']);
    \App\Models\Feedback::create([
        'user_id' => auth()->id(),
        'message' => $request->message,
    ]);

    return back()->with('success', 'Merci pour votre retour.');
}
}
