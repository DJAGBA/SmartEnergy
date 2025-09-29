<?php

namespace App\Exports;

use App\Models\Poste;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PostesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Poste::with('zones.agence')->get()->map(function ($poste) {
            return [
                'Date de création' => $poste->created_at->format('d/m/Y H:i'),
                'Nom du poste' => $poste->nom,
                'Zone' => $poste->zones->pluck('nom')->join(', ') ?: '—',
                'Agence' => $poste->zones->pluck('agence.nom')->unique()->join(', ') ?: '—',
            ];
        });
    }

    public function headings(): array
    {
        return ['Date de création', 'Nom du poste', 'Zone', 'Agence'];
    }
}
