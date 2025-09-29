<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poste;
use App\Exports\PostesExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class HistoriqueController extends Controller
{
    public function index()
    {
        // Pour la vue WEB : pagination
        $postes = Poste::with('zone.agence')
                       ->orderBy('created_at', 'desc')
                       ->paginate(10);

        return view('historique.index', compact('postes'));
    }

    public function exportExcel()
    {
        return Excel::download(new PostesExport, 'historique_postes.xlsx');
    }

    public function exportPdf()
    {
        // Pour le PDF : TOUTES les données, SANS pagination !
        $postes = Poste::with('zone.agence')
                       ->orderBy('created_at', 'desc')
                       ->get(); 
        $pdf = Pdf::loadView('historique.pdf', compact('postes'));
        return $pdf->download('historique_postes.pdf');
    }
}