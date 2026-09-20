<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Commande;
use App\Models\Produit;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'nbUtilisateurs' => User::count(),
            'nbProduits' => Produit::count(),
            'nbCategories' => Categorie::count(),
            'nbCommandes' => Commande::count(),
            'dernieresCommandes' => Commande::with('user')->latest()->take(5)->get(),
        ]);
    }
}
