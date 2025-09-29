<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poste;
use App\Models\Client;

class ClientMigrationController extends Controller
{
    /**
     * Affiche le formulaire de migration des clients.
     */
    public function form($source_poste_id)
    {
        // Récupère le poste source ou lance 404 si introuvable
        $sourcePoste = Poste::findOrFail($source_poste_id);

        // Vérifie que le poste source est bien hors service
        if ($sourcePoste->etat === 'actif') {
            return redirect()->route('postes.index')
                             ->with('error', 'Ce poste est encore actif. La migration est réservée aux postes hors service.');
        }

        // Récupère tous les clients du poste source
        $clients = Client::where('poste_id', $source_poste_id)->get();

        // Liste des postes actifs disponibles pour la migration
        $postesActifs = Poste::where('etat', 'actif')
                             ->where('id', '!=', $source_poste_id)
                             ->get();

        // Passe les bonnes variables à la vue
        return view('client.migration', [
            'sourcePoste' => $sourcePoste,
            'clients' => $clients,
            'postesActifs' => $postesActifs
        ]);
    }

    /**
     * Exécute la migration des clients vers un nouveau poste.
     */
    public function migrate(Request $request, $source_poste_id)
    {
        $request->validate([
            'destination_poste_id' => 'required|exists:postes,id',
        ]);

        $sourcePoste = Poste::findOrFail($source_poste_id);
        $destinationPoste = Poste::findOrFail($request->destination_poste_id);

        // Vérifie que le poste source est hors service
        if ($sourcePoste->etat === 'actif') {
            return redirect()->route('postes.index')
                             ->with('error', 'Le poste source est encore actif. Migration annulée.');
        }

        // Vérifie que le poste destination est actif
        if ($destinationPoste->etat !== 'actif') {
            return redirect()->back()
                             ->with('error', 'Le poste de destination doit être actif.');
        }

        // Migration des clients
        $clientsMigrés = Client::where('poste_id', $source_poste_id)
                               ->update(['poste_id' => $destinationPoste->id]);

        return redirect()->route('postes.index')
                         ->with('success', $clientsMigrés . ' client(s) migré(s) vers le poste "' . $destinationPoste->nom . '".');
    }
}
