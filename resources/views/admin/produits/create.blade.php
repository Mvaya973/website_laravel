@extends('admin.layout')

@section('titre', 'Nouveau produit')

@section('content')
    <div class="card" style="max-width: 640px;">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.produits.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <x-input-label for="nom" value="Nom du produit" />
                    <x-text-input id="nom" name="nom" type="text" class="mt-1" :value="old('nom')" required autofocus />
                    <x-input-error :messages="$errors->get('nom')" class="mt-1" />
                </div>

                <div class="mb-3">
                    <x-input-label for="description" value="Description" />
                    <textarea id="description" name="description" rows="3" class="form-control mt-1">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-1" />
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <x-input-label for="prix" value="Prix (€)" />
                        <x-text-input id="prix" name="prix" type="number" step="0.01" min="0" class="mt-1" :value="old('prix')" required />
                        <x-input-error :messages="$errors->get('prix')" class="mt-1" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <x-input-label for="stock" value="Stock" />
                        <x-text-input id="stock" name="stock" type="number" min="0" class="mt-1" :value="old('stock', 0)" required />
                        <x-input-error :messages="$errors->get('stock')" class="mt-1" />
                    </div>
                </div>

                <div class="mb-3">
                    <x-input-label for="image" value="Image du produit" />
                    <input id="image" name="image" type="file" accept="image/*" class="form-control mt-1">
                    <x-input-error :messages="$errors->get('image')" class="mt-1" />
                </div>

                <div class="mb-3">
                    <x-input-label value="Catégories" />
                    <div class="border rounded p-2" style="max-height: 200px; overflow-y: auto;">
                        @forelse ($categories as $categorie)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $categorie->id }}" id="cat-{{ $categorie->id }}"
                                    {{ in_array($categorie->id, old('categories', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="cat-{{ $categorie->id }}">
                                    {{ $categorie->nom }}
                                </label>
                            </div>
                        @empty
                            <p class="text-muted small mb-0">Aucune catégorie pour le moment.</p>
                        @endforelse
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <x-primary-button>Créer</x-primary-button>
                    <a href="{{ route('admin.produits.index') }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection
