<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class PanierController extends Controller
{
    private const COOKIE = 'panier';

    private const DUREE_MINUTES = 60 * 24 * 30;

    private function lire(Request $request): array
    {
        $contenu = json_decode($request->cookie(self::COOKIE, '[]'), true);

        return is_array($contenu) ? $contenu : [];
    }

    public function index(Request $request): View
    {
        $panier = $this->lire($request);

        $produits = Produit::query()->whereIn('id', array_keys($panier))->get();

        $lignes = $produits->map(function (Produit $produit) use ($panier) {
            $quantite = $panier[$produit->id];

            return [
                'produit' => $produit,
                'quantite' => $quantite,
                'sous_total' => $produit->prix * $quantite,
            ];
        });

        $total = $lignes->sum('sous_total');

        return view('panier.index', [
            'lignes' => $lignes,
            'total' => $total,
        ]);
    }

    public function ajouter(Request $request, Produit $produit): RedirectResponse
    {
        $data = $request->validate([
            'qte' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $quantite = $data['qte'] ?? 1;

        $panier = $this->lire($request);
        $panier[$produit->id] = ($panier[$produit->id] ?? 0) + $quantite;

        Cookie::queue(self::COOKIE, json_encode($panier), self::DUREE_MINUTES);

        return back()->with('status', $produit->nom.' ajouté au panier.');
    }

    public function mettreAJour(Request $request, Produit $produit): RedirectResponse
    {
        $data = $request->validate([
            'qte' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        $panier = $this->lire($request);
        $panier[$produit->id] = $data['qte'];

        Cookie::queue(self::COOKIE, json_encode($panier), self::DUREE_MINUTES);

        return back()->with('status', 'Panier mis à jour.');
    }

    public function retirer(Request $request, Produit $produit): RedirectResponse
    {
        $panier = $this->lire($request);
        unset($panier[$produit->id]);

        Cookie::queue(self::COOKIE, json_encode($panier), self::DUREE_MINUTES);

        return back()->with('status', 'Produit retiré du panier.');
    }

    public function vider(): RedirectResponse
    {
        Cookie::queue(Cookie::forget(self::COOKIE));

        return back()->with('status', 'Panier vidé.');
    }
}
