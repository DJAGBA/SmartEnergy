<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupure;
use App\Models\Zone;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HistoriqueCoupuresExport;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CoupurePlanifieeNotification;
use App\Models\Poste;
use App\Models\Agence;



class CoupureController extends Controller
{
    // Affiche la liste des coupures
    public function index()
    {
        $coupures = Coupure::with('zone')->latest()->paginate(10);
        return view('coupures.index', compact('coupures'));
    }

    // Affiche le formulaire de création
    public function create()
    {
        $zones = Zone::all();
        return view('coupures.create', compact('zones'));
    }

    // Enregistre une nouvelle coupure
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after:date_debut',
            'motif' => 'required|string',
            'priorite' => 'required|in:faible,moyenne,élevée',
            'zone_id' => 'required|exists:zones,id',
        ]);

        $debut = Carbon::parse($validated['date_debut']);
        $fin = Carbon::parse($validated['date_fin']);
        $duree = $debut->diffInMinutes($fin);
        $gestionnaireId = auth()->id();

       $coupure = Coupure::create([
    'date_debut' => $debut,
    'date_fin' => $fin,
    'duree_prevue' => $duree,
    'motif' => $validated['motif'],
    'priorite' => $validated['priorite'],
    'zone_id' => $validated['zone_id'],
    'etat' => 'planifiee',
    'gestionnaire_id' => $gestionnaireId,
    
]);
Notification::send(auth()->user(), new CoupurePlanifieeNotification($coupure));


        return redirect()->route('coupures.index')->with('success', 'Coupure planifiée avec succès.');
    }

    // Affiche le formulaire d'édition
    public function edit(string $id)
    {
        $coupure = Coupure::findOrFail($id);
        $zones = Zone::all();
        return view('coupures.edit', compact('coupure', 'zones'));
    }

    // Met à jour une coupure existante
    public function update(Request $request, string $id)
    {
        $coupure = Coupure::findOrFail($id);

        $validated = $request->validate([
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after:date_debut',
            'motif' => 'required|string',
            'priorite' => 'required|in:faible,moyenne,élevée',
            'zone_id' => 'required|exists:zones,id',
        ]);

        $debut = Carbon::parse($validated['date_debut']);
        $fin = Carbon::parse($validated['date_fin']);
        $duree = $debut->diffInMinutes($fin);

        $coupure->update([
            'date_debut' => $debut,
            'date_fin' => $fin,
            'duree_prevue' => $duree,
            'motif' => $validated['motif'],
            'priorite' => $validated['priorite'],
            'zone_id' => $validated['zone_id'],
        ]);

        return redirect()->route('coupures.index')->with('success', 'Coupure mise à jour.');
    }

    // Supprime une coupure
    public function destroy(string $id)
    {
        $coupure = Coupure::findOrFail($id);
        $coupure->delete();
        return redirect()->route('coupures.index')->with('success', 'Coupure supprimée.');
    }

    public function historique()
{
    $coupures = Coupure::with('zone', 'gestionnaire')
        ->where('date_fin', '<', now())
        ->orderByDesc('date_fin')
        ->paginate(10);

    return view('coupures.historique', compact('coupures'));
}


public function dashboard()
{
    // Met à jour automatiquement les coupures expirées
Coupure::where('etat', 'planifiee')
    ->where('date_fin', '<', now())
    ->update(['etat' => 'terminee']);

    $user = auth()->user();
    $stats = [];

    if ($user->hasRole('gestionnaire')) {
       $stats = [
    // Toutes les coupures planifiées, peu importe leur date
    'planifiees' => Coupure::where('etat', 'planifiee')->count(),

    // Coupures planifiées dont la période est en cours (entre date_debut et date_fin)
    'encours' => Coupure::where('etat', 'planifiee')
        ->where('date_debut', '<=', now())
        ->where('date_fin', '>=', now())
        ->count(),

    // Coupures terminées
    'terminees' => Coupure::where('etat', 'terminee')->count(),
    

    // Répartition par zone (nom de la zone)
    'zones' => Coupure::with('zone')->get()
        ->groupBy('zone.nom')
        ->map(fn($group) => $group->count())
        ->toArray(),

    // Répartition par motif
    'types' => Coupure::select('motif')
        ->groupBy('motif')
        ->selectRaw('motif, COUNT(*) as total')
        ->pluck('total', 'motif')
        ->toArray(),

    // Coupures par mois (format YYYY-MM), PostgreSQL compatible
    'periodes' => Coupure::selectRaw("TO_CHAR(date_debut, 'YYYY-MM') as mois, COUNT(*) as total")
        ->groupBy('mois')
        ->orderBy('mois')
        ->pluck('total', 'mois')
        ->map(fn($val) => (int) $val) // force les valeurs à être numériques
        ->toArray(),
];
        return view('dashboards.gestionnaire', compact('stats'));
    }

    if ($user->hasRole('technicien')) {
        $stats = [
            'agences' => \App\Models\Agence::count(),
            'zones' => \App\Models\Zone::count(),
            'postes' => \App\Models\Poste::count(),
        ];

        return view('dashboards.technicien', compact('stats'));
    }

    return view('dashboards.default');
}
public function exportCoupuresPdf()
{
    $coupures = Coupure::with('zone', 'gestionnaire')
        ->where('date_fin', '<', now())
        ->orderByDesc('date_fin')
        ->get();

    return Pdf::loadView('coupures.historique_pdf', compact('coupures'))
        ->download('historique_coupures.pdf');
}

public function exportCoupuresExcel()
{
    return Excel::download(new HistoriqueCoupuresExport, 'historique_coupures.xlsx');
}
public function terminer(Coupure $coupure)
{
    if ($coupure->etat !== 'planifiee') {
        return back()->with('error', 'Cette coupure est déjà terminée ou annulée.');
    }

    $coupure->update(['etat' => 'terminee']);

    return back()->with('success', 'Coupure marquée comme terminée.');
}



public function impact()
{
    // Fréquence des coupures par zone
    $frequences = \App\Models\Coupure::with('zone')
        ->selectRaw('zone_id, COUNT(*) as total')
        ->groupBy('zone_id')
        ->get()
        ->map(function ($item) {
            return [
                'zone' => optional($item->zone)->nom,
                'frequence' => $item->total,
            ];
        });

    // Durée moyenne des coupures par zone
    $durees = \App\Models\Coupure::with('zone')
        ->selectRaw('zone_id, AVG(CAST(duree_prevue AS INTEGER)) as moyenne')
        ->groupBy('zone_id')
        ->get()
        ->map(function ($item) {
            return [
                'zone' => optional($item->zone)->nom,
                'moyenne' => round($item->moyenne, 2),
            ];
        });

    // Satisfaction moyenne par zone
    $feedbacks = \App\Models\Feedback::with('zone')
        ->selectRaw('zone_id, AVG(note) as satisfaction')
        ->groupBy('zone_id')
        ->get()
        ->map(function ($item) {
            return [
                'zone' => optional($item->zone)->nom,
                'satisfaction' => round($item->satisfaction, 2),
            ];
        });

    // Retours clients individuels
    $retours = \App\Models\Feedback::with('zone', 'user')
        ->latest()
        ->take(10)
        ->get();

    // Données pour les graphiques
    $labels = $frequences->pluck('zone')->toArray();
    $frequenceData = $frequences->pluck('frequence')->toArray();
    $dureeData = $durees->pluck('moyenne')->toArray();

    return view('coupures.impact', compact(
        'frequences',
        'durees',
        'feedbacks',
        'retours',
        'labels',
        'frequenceData',
        'dureeData'
    ));
}

}