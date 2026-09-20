<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CommandeController extends Controller
{
    public function index(): View
    {
        $commandes = Commande::with('user')->latest()->paginate(10);

        return view('admin.commandes.index', compact('commandes'));
    }

    public function create(): View
    {
        $users = User::orderBy('name')->get();
        $produits = Produit::orderBy('nom')->get();

        return view('admin.commandes.create', compact('users', 'produits'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'adresse_livraison' => ['required', 'string', 'max:255'],
            'statut' => ['required', Rule::in(array_keys(Commande::STATUTS))],
            'quantites' => ['required', 'array'],
            'quantites.*' => ['nullable', 'integer', 'min:0', 'max:1000'],
        ]);

        $lignes = collect($data['quantites'])->filter(fn ($qte) => (int) $qte > 0);

        if ($lignes->isEmpty()) {
            return back()->withInput()->withErrors(['quantites' => 'Sélectionnez au moins un produit avec une quantité supérieure à 0.']);
        }

        $produits = Produit::query()->whereIn('id', $lignes->keys())->get();

        $commande = DB::transaction(function () use ($data, $lignes, $produits) {
            $commande = Commande::create([
                'user_id' => $data['user_id'],
                'statut' => $data['statut'],
                'total' => 0,
                'adresse_livraison' => $data['adresse_livraison'],
            ]);

            $total = 0;

            foreach ($produits as $produit) {
                $quantite = (int) $lignes[$produit->id];

                $commande->produits()->attach($produit->id, [
                    'quantite' => $quantite,
                    'prix_unitaire' => $produit->prix,
                ]);

                $total += $produit->prix * $quantite;
            }

            $commande->update(['total' => $total]);

            return $commande;
        });

        return redirect()->route('admin.commandes.show', $commande)->with('status', 'Commande créée.');
    }

    public function show(Commande $commande): View
    {
        $commande->load('produits', 'user');

        return view('admin.commandes.show', compact('commande'));
    }

    public function update(Request $request, Commande $commande): RedirectResponse
    {
        $data = $request->validate([
            'statut' => ['required', Rule::in(array_keys(Commande::STATUTS))],
        ]);

        $commande->update($data);

        return redirect()->route('admin.commandes.show', $commande)->with('status', 'Statut mis à jour.');
    }

    public function destroy(Commande $commande): RedirectResponse
    {
        $commande->delete();

        return redirect()->route('admin.commandes.index')->with('status', 'Commande supprimée.');
    }
}
