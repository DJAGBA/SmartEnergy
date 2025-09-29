<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Poste;

class MigratePostesZones extends Command
{
    protected $signature = 'migrate:postes-zones';
    protected $description = 'Migrer les relations zone_id vers la table pivot poste_zone';

    public function handle()
    {
        $postes = Poste::whereNotNull('zone_id')->get();
        $count = 0;
        
        foreach($postes as $poste) {
            if ($poste->zones()->count() == 0) {
                $poste->zones()->attach($poste->zone_id);
                $count++;
                $this->info("Zone associée au poste {$poste->code_poste}");
            }
        }
        
        $this->info("{$count} associations créées");
        return 0;
    }
}