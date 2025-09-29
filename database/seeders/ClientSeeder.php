<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Poste;

class ClientSeeder extends Seeder
{
    public function run()
    {
        // Définir les clients à insérer
        $clients = [
            ['nom' => 'Alice', 'reference' => 'C001', 'telephone' => '702000001', 'email' => 'client1@example.com', 'abonne' => true],
            ['nom' => 'Bob', 'reference' => 'C002', 'telephone' => '702000002', 'email' => 'client2@example.com', 'abonne' => false],
            ['nom' => 'Charlie', 'reference' => 'C003', 'telephone' => '702000003', 'email' => 'client3@example.com', 'abonne' => true],
            ['nom' => 'David', 'reference' => 'C004', 'telephone' => '702000004', 'email' => 'client4@example.com', 'abonne' => false],
            ['nom' => 'Eve', 'reference' => 'C005', 'telephone' => '702000005', 'email' => 'client5@example.com', 'abonne' => true],
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
                            'poste_id' => $poste->id,
                            'agence_id' => $zone->agence_id,
                        ]
                    );
                }
            }
        }
    }
}
