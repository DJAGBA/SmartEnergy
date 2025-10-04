<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AgenceController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\PosteController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CoupureController;    
use App\Http\Controllers\SouscriptionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HistoriqueController;
use App\Http\Controllers\ParametreController;
use App\Http\Controllers\ClientMigrationController;
use App\Http\Controllers\UserNotificationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\GestionnaireController;
use App\Http\Controllers\PortailController;



Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard dynamique selon le rôle - UNE SEULE ROUTE
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->hasRole('admin')) {
        // Pour l'admin, vue simple sans données complexes
        return view('dashboards.admin');
    }

    if ($user->hasRole('gestionnaire')) {
    return app(\App\Http\Controllers\GestionnaireController::class)->index();
}

    if ($user->hasRole('technicien')) {
        // Pour le technicien, utiliser le contrôleur pour les données
        $agences = \App\Models\Agence::all();
        $zones = \App\Models\Zone::withCount('postes')->get();
        $postes = \App\Models\Poste::with('zone')->get();
        
        $stats = [
            'agences' => $agences->count(),
            'zones' => $zones->count(),
            'postes' => $postes->count(),
        ];

        return view('dashboards.technicien', compact('user', 'agences', 'zones', 'postes', 'stats'));
    }

    abort(403, 'Accès non autorisé.');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes du profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::resource('agences', AgenceController::class);
Route::resource('zones', ZoneController::class);
Route::resource('postes', PosteController::class);
Route::resource('clients', ClientController::class);
Route::resource('coupures', CoupureController::class)->except(['show']);

Route::post('souscription', [SouscriptionController::class, 'store']);
Route::post('souscription/valider', [SouscriptionController::class, 'valider']);
 Route::get('/historique', [HistoriqueController::class, 'index'])->name('historique.index');
Route::get('/historique/export/pdf', [HistoriqueController::class, 'exportPdf'])->name('historique.export.pdf');
Route::get('/historique/export/excel', [HistoriqueController::class, 'exportExcel'])->name('historique.export.excel');
Route::get('/parametres', [ParametreController::class, 'index'])->name('parametres.index');


Route::get('/coupures/historique/export/pdf', [CoupureController::class, 'exportCoupuresPdf'])->name('coupures.export.pdf');
Route::get('/coupures/historique/export/excel', [CoupureController::class, 'exportCoupuresExcel'])->name('coupures.export.excel');

Route::get('/coupures/historique', [CoupureController::class, 'historique'])->name('coupures.historique');
Route::get('/coupures/impact', [CoupureController::class, 'impact'])->name('coupures.impact');
Route::get('/dashboard', [CoupureController::class, 'dashboard'])->name('dashboard');
Route::get('/client/migration/{source_poste_id}', [ClientMigrationController::class, 'form'])->name('client.migration.form');
Route::post('/client/migration/{source_poste_id}', [ClientMigrationController::class, 'migrate'])->name('client.migration.execute');
Route::patch('/postes/{poste}/etat', [PosteController::class, 'changerEtat'])->name('postes.changerEtat');
Route::post('/client/migration/{source_poste}', [ClientController::class, 'migrationExecute'])->name('client.migration.execute');
Route::get('/agences/{agence}/zones', [ZoneController::class, 'getZones']);
Route::get('/user-notifications', [UserNotificationController::class, 'index'])->name('user-notifications.index');
Route::get('/zones/{zone}/postes', [ZoneController::class, 'getPostes']);
Route::resource('roles', RoleController::class);
Route::patch('/coupures/{coupure}/terminer', [CoupureController::class, 'terminer'])->name('coupures.terminer');

Route::middleware(['auth'])->group(function () {
    Route::get('/portail', [PortailController::class, 'index'])->name('portail');
    Route::get('/coupures/search', [PortailController::class, 'search'])->name('coupures.search');
    Route::post('/abonnement/update', [PortailController::class, 'updateAbonnement'])->name('abonnement.update');
    Route::post('/feedback/store', [PortailController::class, 'storeFeedback'])->name('feedback.store');
});
Route::get('/portail/coupure/{id}', [PortailController::class, 'show'])->name('portail.coupure');
Route::get('/coupures/recherche', [PortailController::class, 'recherche'])->name('coupures.recherche');



require __DIR__.'/auth.php';