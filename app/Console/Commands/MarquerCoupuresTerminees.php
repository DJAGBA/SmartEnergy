<?php

namespace App\Console\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Console\Command;
use App\Models\Coupure;
use Carbon\Carbon;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'coupures:terminer')]
class MarquerCoupuresTerminees extends Command
{
    protected $description = 'Marque les coupures comme terminées si la date de fin est dépassée';

    public function handle()
    {
        $coupures = Coupure::where('etat', 'planifiee')
            ->where('date_fin', '<=', Carbon::now())
            ->get();

        foreach ($coupures as $coupure) {
            $coupure->update(['etat' => 'terminee']);
            $this->info("Coupure #{$coupure->id} marquée comme terminée.");
        }

        $this->info('Mise à jour terminée.');
    }
}