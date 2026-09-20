<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CommandeController extends Controller
{
    private function lirePanier(Request $request): array
    {
        $contenu = json_decode($request->cookie('panier', '[]'), true);

        return is_array($contenu) ? $contenu : [];
    }

    public function create(Request $request): View|RedirectResponse
    {
        $panier = $this->lirePanier($request);

        if (empty($panier)) {
            return redirect()->route('panier.index')->with('status', 'Votre panier est vide.');
        }

        $produits = Produit::query()->whereIn('id', array_keys($panier))->get();

        $lignes = $produits->map(fn (Produit $produit) => [
            'produit' => $produit,
            'quantite' => $panier[$produit->id],
            'sous_total' => $produit->prix * $panier[$produit->id],
        ]);

        return view('commandes.create', [
            'lignes' => $lignes,
            'total' => $lignes->sum('sous_total'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'adresse_livraison' => ['required', 'string', 'max:255'],
        ]);

        $panier = $this->lirePanier($request);

        if (empty($panier)) {
            return redirect()->route('panier.index')->with('status', 'Votre panier est vide.');
        }

        $produits = Produit::query()->whereIn('id', array_keys($panier))->get();

        if ($produits->isEmpty()) {
            return redirect()->route('panier.index')->with('status', 'Votre panier est vide.');
        }

        $commande = DB::transaction(function () use ($produits, $panier, $data, $request) {
            $commande = Commande::create([
                'user_id' => $request->user()->id,
                'statut' => 'en_attente',
                'total' => 0,
                'adresse_livraison' => $data['adresse_livraison'],
            ]);

            $total = 0;

            foreach ($produits as $produit) {
                $quantite = $panier[$produit->id];

                $commande->produits()->attach($produit->id, [
                    'quantite' => $quantite,
                    'prix_unitaire' => $produit->prix,
                ]);

                $total += $produit->prix * $quantite;
            }

            $commande->update(['total' => $total]);

            return $commande;
        });

        Cookie::queue(Cookie::forget('panier'));

        return redirect()->route('commandes.show', $commande)
            ->with('status', 'Votre commande a bien été enregistrée.');
    }

    public function index(Request $request): View
    {
        $commandes = $request->user()->commandes()->latest()->paginate(10);

        return view('commandes.index', [
            'commandes' => $commandes,
        ]);
    }

    public function show(Request $request, Commande $commande): View
    {
        abort_unless($commande->user_id === $request->user()->id, 403);

        $commande->load('produits');

        return view('commandes.show', [
            'commande' => $commande,
        ]);
    }
}
