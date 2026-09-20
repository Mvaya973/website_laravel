<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategorieController extends Controller
{
    public function index(): View
    {
        $categories = Categorie::withCount('produits')->orderBy('nom')->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        $produits = Produit::orderBy('nom')->get();

        return view('admin.categories.create', compact('produits'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255', 'unique:categories,nom'],
            'produits' => ['sometimes', 'array'],
            'produits.*' => ['integer', 'exists:produits,id'],
        ]);

        $categorie = Categorie::create([
            'nom' => $data['nom'],
            'slug' => Str::slug($data['nom']),
        ]);

        $categorie->produits()->sync($data['produits'] ?? []);

        return redirect()->route('admin.categories.index')->with('status', 'Catégorie créée.');
    }

    public function edit(Categorie $categorie): View
    {
        $produits = Produit::orderBy('nom')->get();
        $categorie->load('produits');

        return view('admin.categories.edit', compact('categorie', 'produits'));
    }

    public function update(Request $request, Categorie $categorie): RedirectResponse
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255', Rule::unique('categories', 'nom')->ignore($categorie->id)],
            'produits' => ['sometimes', 'array'],
            'produits.*' => ['integer', 'exists:produits,id'],
        ]);

        $categorie->update([
            'nom' => $data['nom'],
            'slug' => Str::slug($data['nom']),
        ]);

        $categorie->produits()->sync($data['produits'] ?? []);

        return redirect()->route('admin.categories.index')->with('status', 'Catégorie mise à jour.');
    }

    public function destroy(Categorie $categorie): RedirectResponse
    {
        $categorie->delete();

        return redirect()->route('admin.categories.index')->with('status', 'Catégorie supprimée.');
    }
}
