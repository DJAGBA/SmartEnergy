<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Poste;
use App\Models\Zone;
use Illuminate\Support\Str;

class PosteSeeder extends Seeder
{
    public function run(): void
    {
        $zones = Zone::all();

        foreach ($zones as $zone) {
            $nombrePostes = rand(1, 3);

            for ($i = 1; $i <= $nombrePostes; $i++) {
                Poste::create([
                    'nom' => "Poste {$i} - " . $zone->nom,
                    'zone_id' => $zone->id,
                    'etat' => collect(['actif', 'hors_service', 'en_attente'])->random(),
                    'code_poste' => 'P' . str_pad($zone->id . $i, 4, '0', STR_PAD_LEFT),
                ]);
            }
        }
    }
}