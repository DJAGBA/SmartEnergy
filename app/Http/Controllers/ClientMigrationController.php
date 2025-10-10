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
        $sourcePoste = Poste::findOrFail($source_poste_id);

        if ($sourcePoste->etat === 'actif') {
            return redirect()->route('postes.index')
                             ->with('error', 'Ce poste est encore actif. La migration est réservée aux postes hors service.');
        }

        $clients = Client::where('poste_id', $source_poste_id)->get();

        $postesCibles = Poste::whereIn('etat', ['actif', 'en_attente'])
                             ->where('id', '!=', $source_poste_id)
                             ->with('zones')
                             ->get();

        return view('client.migration', [
            'sourcePoste' => $sourcePoste,
            'clients' => $clients,
            'postesCibles' => $postesCibles
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
        $destinationPoste = Poste::with('zones')->findOrFail($request->destination_poste_id);

        if ($sourcePoste->etat === 'actif') {
            return redirect()->route('postes.index')
                             ->with('error', 'Le poste source est encore actif. Migration annulée.');
        }

        if (!in_array($destinationPoste->etat, ['actif', 'en_attente'])) {
            return redirect()->back()
                             ->with('error', 'Le poste de destination doit être actif ou en attente.');
        }

        $zone = $destinationPoste->zones->first();
        $clientsMigrés = 0;

        Client::where('poste_id', $source_poste_id)->get()->each(function ($client) use ($destinationPoste, $zone, &$clientsMigrés) {
            $client->poste_id = $destinationPoste->id;
            $client->zone_id = $zone?->id;

            if ($destinationPoste->etat === 'en_attente') {
                $client->etat = 'actif';
            }

            $client->save();
            $clientsMigrés++;
        });

        // ✅ Activation automatique du poste destination
        if ($clientsMigrés > 0 && $destinationPoste->etat === 'en_attente') {
            Poste::where('id', $destinationPoste->id)->update(['etat' => 'actif']);
            $destinationPoste = Poste::find($destinationPoste->id); // recharge
        }

        // ✅ Archivage automatique du poste source s’il est vidé
        if (Client::where('poste_id', $sourcePoste->id)->count() === 0) {
            Poste::where('id', $sourcePoste->id)->update(['archive' => true]);
            $sourcePoste = Poste::find($sourcePoste->id); // recharge
        }

        return redirect()->route('postes.index')
                         ->with('success', $clientsMigrés . ' client(s) migré(s) vers le poste "' . $destinationPoste->code_poste . '".' .
                             ($destinationPoste->etat === 'actif' ? ' Le poste de destination a été activé.' : '') .
                             ($sourcePoste->archive ? ' Le poste source a été archivé.' : ''));
    }
}