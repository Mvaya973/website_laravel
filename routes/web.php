<?php

use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProduitController::class, 'index'])->name('home');
Route::get('/produits/{produit}', [ProduitController::class, 'show'])->name('produits.show');

Route::prefix('panier')->name('panier.')->group(function () {
    Route::get('/', [PanierController::class, 'index'])->name('index');
    Route::post('/ajouter/{produit}', [PanierController::class, 'ajouter'])->name('ajouter');
    Route::patch('/maj/{produit}', [PanierController::class, 'mettreAJour'])->name('maj');
    Route::delete('/retirer/{produit}', [PanierController::class, 'retirer'])->name('retirer');
    Route::delete('/vider', [PanierController::class, 'vider'])->name('vider');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('home');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/commande', [CommandeController::class, 'create'])->name('commandes.create');
    Route::post('/commande', [CommandeController::class, 'store'])->name('commandes.store');
    Route::get('/mes-commandes', [CommandeController::class, 'index'])->name('commandes.index');
    Route::get('/mes-commandes/{commande}', [CommandeController::class, 'show'])->name('commandes.show');
});

require __DIR__.'/auth.php';

require __DIR__.'/admin.php';
