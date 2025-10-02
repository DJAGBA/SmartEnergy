<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Poste;

class ClientSeeder extends Seeder
{
    public function run()
    {
        // Clients fictifs (sans DJAGBA ici)
        $clients = [
            ['nom' => 'Alice', 'reference' => 'C001', 'telephone' => '+228702000001', 'email' => 'client1@example.com', 'abonne' => true, 'canal_preferé' => json_encode(['sms'])],
            ['nom' => 'Bob', 'reference' => 'C002', 'telephone' => '+228702000002', 'email' => 'client2@example.com', 'abonne' => false, 'canal_preferé' => null],
            ['nom' => 'Charlie', 'reference' => 'C003', 'telephone' => '+228702000003', 'email' => 'client3@example.com', 'abonne' => true, 'canal_preferé' => json_encode(['email'])],
            ['nom' => 'David', 'reference' => 'C004', 'telephone' => '+228702000004', 'email' => 'client4@example.com', 'abonne' => false, 'canal_preferé' => null],
            ['nom' => 'Eve', 'reference' => 'C005', 'telephone' => '+228702000005', 'email' => 'client5@example.com', 'abonne' => true, 'canal_preferé' => json_encode(['sms'])],
        ];

        // Récupérer tous les postes actifs ou hors service
        $postes = Poste::whereIn('etat', ['actif', 'hors service'])->get();

        foreach ($postes as $poste) {
            foreach ($poste->zones as $zone) {
                foreach ($clients as $client) {
                    Client::updateOrCreate(
                        ['reference' => $client['reference'] . '-' . $zone->id],
                        [
                            'nom' => $client['nom'],
                            'telephone' => $client['telephone'],
                            'email' => $client['email'],
                            'abonne' => $client['abonne'],
                            'canal_preferé' => $client['canal_preferé'],
                            'poste_id' => $poste->id,
                            'agence_id' => $zone->agence_id,
                        ]
                    );
                }
            }
        }

        // ✅ Insérer DJAGBA une seule fois, avec les deux canaux préférés
        Client::updateOrCreate(
            ['reference' => 'C006'],
            [
                'nom' => 'DJAGBA',
                'telephone' => '+22870203410',
                'email' => 'veroniquedjagba@gmail.com',
                'abonne' => true,
                'canal_preferé' => json_encode(['sms', 'email']),
                'poste_id' => 14, // Poste lié à une coupure
                'agence_id' => 1,  // Agence valide
            ]
        );
    }
}