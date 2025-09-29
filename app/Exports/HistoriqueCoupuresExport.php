<?php
namespace App\Exports;

use App\Models\Coupure;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HistoriqueCoupuresExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Coupure::with('zone', 'gestionnaire')
            ->where('date_fin', '<', now())
            ->get()
            ->map(function ($coupure) {
                $minutes = $coupure->duree_prevue ?? 0;
                $heures = intdiv($minutes, 60);
                $reste = $minutes % 60;
                $duree = ($heures > 0 ? $heures . 'h ' : '') . $reste . 'min';

                return [
                    'Début' => $coupure->date_debut->format('d/m/Y H:i'),
                    'Fin' => $coupure->date_fin->format('d/m/Y H:i'),
                    'Durée' => $duree,
                    'Zone' => optional($coupure->zone)->nom ?? 'Zone inconnue',
                    'Motif' => $coupure->motif,
                    'Priorité' => ucfirst($coupure->priorite),
                   
                ];
            });
    }

    public function headings(): array
    {
        return ['Début', 'Fin', 'Durée', 'Zone', 'Motif', 'Priorité', 'Gestionnaire'];
    }
}