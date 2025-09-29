<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Zone;
use App\Models\Agence;

class ZoneSeeder extends Seeder
{
    public function run()
    {
        $agences = Agence::all();

        if ($agences->count() < 5) {
            throw new \Exception('Il faut au moins 5 agences pour ce seeder.');
        }

        // 2 premières agences → 3 zones chacune
        foreach ($agences->take(2) as $agence) {
            for ($i = 1; $i <= 3; $i++) {
                Zone::create([
                    'nom' => "Zone {$i} - " . $agence->nom,
                    'agence_id' => $agence->id,
                ]);
            }
        }

        // 3 autres agences → 2 zones chacune
        foreach ($agences->slice(2) as $agence) {
            for ($i = 1; $i <= 2; $i++) {
                Zone::create([
                    'nom' => "Zone {$i} - " . $agence->nom,
                    'agence_id' => $agence->id,
                ]);
            }
        }
    }
}