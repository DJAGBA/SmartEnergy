<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Agence;
use App\Models\Zone;
use App\Models\Poste;

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
}