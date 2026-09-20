<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProduitController extends Controller
{
    public function index(): View
    {
        $produits = Produit::with('categories')->orderBy('nom')->paginate(10);

        return view('admin.produits.index', compact('produits'));
    }

    public function create(): View
    {
        $categories = Categorie::orderBy('nom')->get();

        return view('admin.produits.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validerDonnees($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        $produit = Produit::create([
            'nom' => $data['nom'],
            'description' => $data['description'] ?? null,
            'prix' => $data['prix'],
            'stock' => $data['stock'],
            'image' => $data['image'] ?? null,
        ]);

        $produit->categories()->sync($data['categories'] ?? []);

        return redirect()->route('admin.produits.index')->with('status', 'Produit créé.');
    }

    public function edit(Produit $produit): View
    {
        $categories = Categorie::orderBy('nom')->get();
        $produit->load('categories');

        return view('admin.produits.edit', compact('produit', 'categories'));
    }

    public function update(Request $request, Produit $produit): RedirectResponse
    {
        $data = $this->validerDonnees($request);

        if ($request->hasFile('image')) {
            if ($produit->image) {
                Storage::disk('public')->delete($produit->image);
            }

            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        $produit->update([
            'nom' => $data['nom'],
            'description' => $data['description'] ?? null,
            'prix' => $data['prix'],
            'stock' => $data['stock'],
            'image' => $data['image'] ?? $produit->image,
        ]);

        $produit->categories()->sync($data['categories'] ?? []);

        return redirect()->route('admin.produits.index')->with('status', 'Produit mis à jour.');
    }

    public function destroy(Produit $produit): RedirectResponse
    {
        if ($produit->image) {
            Storage::disk('public')->delete($produit->image);
        }

        $produit->delete();

        return redirect()->route('admin.produits.index')->with('status', 'Produit supprimé.');
    }

    private function validerDonnees(Request $request): array
    {
        return $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'prix' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
            'categories' => ['sometimes', 'array'],
            'categories.*' => ['integer', 'exists:categories,id'],
        ]);
    }
}
