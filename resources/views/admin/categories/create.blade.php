@extends('admin.layout')

@section('titre', 'Nouvelle catégorie')

@section('content')
    <div class="card" style="max-width: 640px;">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf

                <div class="mb-3">
                    <x-input-label for="nom" value="Nom de la catégorie" />
                    <x-text-input id="nom" name="nom" type="text" class="mt-1" :value="old('nom')" required autofocus />
                    <x-input-error :messages="$errors->get('nom')" class="mt-1" />
                </div>

                <div class="mb-3">
                    <x-input-label value="Produits associés" />
                    <div class="border rounded p-2" style="max-height: 220px; overflow-y: auto;">
                        @forelse ($produits as $produit)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="produits[]" value="{{ $produit->id }}" id="produit-{{ $produit->id }}"
                                    {{ in_array($produit->id, old('produits', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="produit-{{ $produit->id }}">
                                    {{ $produit->nom }}
                                </label>
                            </div>
                        @empty
                            <p class="text-muted small mb-0">Aucun produit pour le moment.</p>
                        @endforelse
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <x-primary-button>Créer</x-primary-button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection
