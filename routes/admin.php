<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\CategorieController;
use App\Http\Controllers\Admin\CommandeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProduitController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('utilisateurs', UserController::class)
            ->parameters(['utilisateurs' => 'user'])
            ->except(['show']);

        Route::resource('categories', CategorieController::class)->except(['show']);

        Route::resource('produits', ProduitController::class)->except(['show']);

        Route::resource('commandes', CommandeController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy']);
    });
});
