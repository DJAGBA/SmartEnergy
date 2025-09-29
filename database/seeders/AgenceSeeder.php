<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agence;

class AgenceSeeder extends Seeder
{
    public function run()
    {
        $agences = [
            'Agence Centrale',
            'Agence Maritime',
            'Agence Nord',
            'Agence Sud',
            'Agence Plateau',
        ];

        foreach ($agences as $nom) {
            Agence::create(['nom' => $nom]);
        }
    }
}
