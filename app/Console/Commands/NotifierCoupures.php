<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Coupure;
use App\Models\Client;
use App\Notifications\CoupurePlanifieeNotification;
use Carbon\Carbon;

class NotifierCoupures extends Command
{
    protected $signature = 'coupures:notifier';
    protected $description = 'Notifier les clients abonnés des coupures à J-3, J-1 et J';

    public function handle()
    {
        $today = Carbon::today();

        $coupures = Coupure::whereDate('date_debut', $today)
            ->orWhereDate('date_debut', $today->copy()->addDays(1))
            ->orWhereDate('date_debut', $today->copy()->addDays(3))
            ->get();

        foreach ($coupures as $coupure) {
            $clients = Client::where('abonne', true)
                ->where('poste_id', $coupure->poste_id)
                ->get();

            foreach ($clients as $client) {
                $client->notify(new CoupurePlanifieeNotification($coupure));
            }
        }

        $this->info('Notifications envoyées aux clients abonnés.');
    }
}
