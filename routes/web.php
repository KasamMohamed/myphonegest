<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReparationController;
use App\Http\Controllers\PieceController;
use App\Http\Controllers\CaisseController;
use App\Http\Controllers\DepenseController;
use Illuminate\Support\Facades\Route;

// Redirection automatique vers la page de connexion si on arrive sur le site
Route::get('/', function () {
    return redirect()->route('login');
});

// Toutes les routes ci-dessous nécessitent d'être connecté et vérifié
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. Tableau de bord & Comptabilité globale
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Atelier - Gestion des Réparations (Saisie Rapide)
    Route::resource('reparations', ReparationController::class);
    Route::post('/reparations/{id}/pieces', [ReparationController::class, 'ajouterPiece'])->name('reparations.ajouterPiece');
    Route::post('/reparations/{id}/statut', [ReparationController::class, 'updateStatut'])->name('reparations.updateStatut');

    // 3. Inventaire - Gestion du Stock & des Accessoires
    Route::resource('pieces', PieceController::class);
    Route::patch('/pieces/{id}/quantite', [PieceController::class, 'updateQuantite'])->name('pieces.updateQuantite'); // <-- LA LIGNE MANQUANTE

    // 4. Comptoir - Caisse de Vente Rapide
    Route::get('/caisse', [CaisseController::class, 'index'])->name('caisse.index');
    Route::post('/caisse/encaisser', [CaisseController::class, 'encaisser'])->name('caisse.encaisser');
    Route::get('/caisse/{id}/edit', [App\Http\Controllers\CaisseController::class, 'edit'])->name('caisse.edit');
    Route::put('/caisse/{id}', [App\Http\Controllers\CaisseController::class, 'update'])->name('caisse.update');
    Route::delete('/caisse/{id}', [App\Http\Controllers\CaisseController::class, 'destroy'])->name('caisse.destroy');

    // 5. Comptabilité - Gestion des Dépenses & Charges
    Route::resource('depenses', DepenseController::class);

    // 6. Paramètres du profil utilisateur (Généré par Laravel Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
