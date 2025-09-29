<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupure;
use App\Models\Zone;
use Carbon\Carbon;

class GestionnaireController extends Controller
{
    public function index()
    {
        // Vue synthétique
        $stats = [
            'planifiees' => Coupure::where('etat', 'planifiee')->count(),
            'encours' => Coupure::where('etat', 'en_cours')->count(),
            'terminees' => Coupure::where('etat', 'terminee')->count(),
        ];

        // Statistiques par zone
        $zones = Zone::withCount('coupures')->get();
        $stats['zones'] = $zones->mapWithKeys(function ($zone) {
            return [$zone->nom => $zone->coupures_count];
        })->toArray();

        // Statistiques par type
        $types = Coupure::selectRaw('type, COUNT(*) as total')
                        ->groupBy('type')
                        ->pluck('total', 'type');
        $stats['types'] = $types->toArray();

        // Statistiques par période
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $currentMonth = Carbon::now()->month;

        $stats['periodes'] = [
            'Aujourd’hui' => Coupure::whereDate('date_debut', $today)->count(),
            'Cette semaine' => Coupure::whereBetween('date_debut', [$startOfWeek, $endOfWeek])->count(),
            'Ce mois' => Coupure::whereMonth('date_debut', $currentMonth)->count(),
        ];

        return view('dashboards.gestionnaire', compact('stats'));
    }
}