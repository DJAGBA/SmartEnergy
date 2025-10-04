<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Agence;
use App\Models\Zone;
use App\Models\Poste;
use App\Models\Signalement;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        $agences = Agence::all();
        $zones = Zone::withCount('postes')->get();
        $postes = Poste::with('zone')->get();
        $stats = [
            'agences' => $agences->count(),
            'zones' => $zones->count(),
            'postes' => $postes->count(),
        ];

        return view('dashboards.technicien', compact('user', 'agences', 'zones', 'postes', 'stats'));
    }
    public function indexNotifications()
{
    $notifications = auth()->user()->notifications()->latest()->get();
    return view('user-notifications.index', compact('notifications'));
}
public function signalements()
{
    $signalements = Signalement::with('poste', 'gestionnaire')
        ->orderByDesc('created_at')
        ->get();

    return view('technicien.signalements', compact('signalements'));
}


$postesHorsService = Poste::where('etat', 'hors_service')->get();
$techniciens = User::where('role', 'technicien')->get();

foreach ($postesHorsService as $poste) {
    foreach ($techniciens as $tech) {
        $tech->notify(new PosteProblemeNotification("Le poste {$poste->code_poste} est hors service.", $poste->id));
    }
}


}