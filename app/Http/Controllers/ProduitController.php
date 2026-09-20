<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProduitController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Categorie::orderBy('nom')->get();

        $selectedCategory = $request->query('cat');

        $products = Produit::query()
            ->when($selectedCategory, function ($query) use ($selectedCategory) {
                $query->whereHas('categories', function ($q) use ($selectedCategory) {
                    $q->where('categories.id', $selectedCategory);
                });
            })
            ->orderBy('nom')
            ->paginate(9)
            ->withQueryString();

        return view('welcome', [
            'categories' => $categories,
            'products' => $products,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    public function show(Produit $produit): View
    {
        $produit->load('categories');

        return view('produits.show', [
            'produit' => $produit,
        ]);
    }
}
