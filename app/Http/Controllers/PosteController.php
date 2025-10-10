<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Zone;
use App\Models\Poste;
use App\Models\Agence;

class PosteController extends Controller
{
  public function index(Request $request)
{
    $query = Poste::with(['agence', 'zones.agence'])->orderBy('created_at', 'desc');

    if ($request->filled('etat')) {
        switch ($request->etat) {
            case 'archived_actif':
                $query->where('etat', 'actif')->where('archive', true);
                break;
            case 'archived_hors_service':
                $query->where('etat', 'hors_service')->where('archive', true);
                break;
            case 'archived_en_attente':
                $query->where('etat', 'en_attente')->where('archive', true);
                break;
            case 'actif':
            case 'hors_service':
            case 'en_attente':
                $query->where('etat', $request->etat)->where('archive', false);
                break;
        }
    }

    $postes = $query->paginate(10);
    return view('postes.index', compact('postes'));
}

    public function create()
    {
        $agences = Agence::all();
        return view('postes.create', compact('agences'));
    }

   public function store(Request $request)
{
    // Validation
    $validated = $request->validate([
        'agence_id' => 'required|exists:agences,id',
        'zone_id' => 'required|array|min:1',
        'zone_id.*' => 'exists:zones,id',
    ]);

    try {
        DB::beginTransaction();

        // Générer le code automatique
        $dernierPoste = Poste::where('code_poste', 'like', 'PST-%')
            ->orderByRaw("CAST(SUBSTRING(code_poste FROM 5) AS INTEGER) DESC")
            ->first();

        $nouveauNumero = $dernierPoste 
            ? intval(preg_replace('/PST-(\d+)/', '$1', $dernierPoste->code_poste)) + 1
            : 1;

        $codePoste = 'PST-' . str_pad($nouveauNumero, 3, '0', STR_PAD_LEFT);

        // Créer le poste
        $poste = Poste::create([
            'code_poste' => $codePoste,
            'agence_id' => $validated['agence_id'], 
            'etat' => 'en_attente',
        ]);

        // Associer les zones sélectionnées
        $poste->zones()->attach($validated['zone_id']);

        DB::commit();

        return redirect()->route('postes.index')
            ->with('success', "Poste {$codePoste} créé avec succès.");
    } catch (\Exception $e) {
        DB::rollback();
        \Log::error('Erreur création poste: ' . $e->getMessage());

        // Afficher le message d'erreur complet pour débogage
        return back()->withInput()->with('error', 'Erreur lors de la création du poste: ' . $e->getMessage());
    }
}


    public function edit(Poste $poste)
    {
        $agences = Agence::all();
        $zones = Zone::all();
        return view('postes.edit', compact('poste', 'agences', 'zones'));
    }

    public function update(Request $request, Poste $poste)
{
    // Valider les champs
    $validated = $request->validate([
        'code_poste' => 'required|string|max:255',
        'zones' => 'required|array',
        'zones.*' => 'exists:zones,id',
    ]);

    // Mettre à jour le poste 
    $poste->update([
        'code_poste' => $validated['code_poste'],
    ]);

    // Synchroniser les zones many-to-many
    $poste->zones()->sync($validated['zones']);

    return redirect()->route('postes.index')->with('success', 'Poste mis à jour avec succès !');
}


    public function show($id)
    {
        $poste = Poste::with(['zones.agence', 'clients'])->findOrFail($id);
        return view('postes.show', compact('poste'));
    }

    public function destroy(Poste $poste)
    {
        if ($poste->etat === 'actif') {
            return redirect()->back()
                ->with('error', 'Impossible de supprimer un poste actif.');
        }

        try {
            DB::beginTransaction();

            $poste->zones()->detach();
            $poste->delete();

            DB::commit();

            return redirect()->route('postes.index')
                ->with('success', 'Poste supprimé avec succès.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression.');
        }
    }

    public function changerEtat(Poste $poste)
    {
        if ($poste->etat === 'actif') {
            $poste->update(['etat' => 'hors_service']);

            return redirect()->route('postes.index')
                ->with('success', "Le poste {$poste->code_poste} a été marqué hors service.");
        }

        return redirect()->back()
            ->with('error', 'Ce poste n\'est pas actif.');
    }

    // Nouvelle méthode pour l'AJAX des zones
    public function getZonesByAgence($agenceId)
    {
        try {
            $zones = Zone::where('agence_id', $agenceId)
                ->select('id', 'nom')
                ->get();

            return response()->json($zones);
        } catch (\Exception $e) {
            \Log::error('Erreur getZonesByAgence: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur serveur'], 500);
        }
    }
}
