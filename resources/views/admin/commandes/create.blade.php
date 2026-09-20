@extends('admin.layout')

@section('titre', 'Nouvelle commande')

@section('content')
    <div class="card" style="max-width: 800px;">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.commandes.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <x-input-label for="user_id" value="Client" />
                        <select name="user_id" id="user_id" class="form-select mt-1" required>
                            <option value="">-- Choisir un client --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('user_id')" class="mt-1" />
                    </div>

                    <div class="col-md-6 mb-3">
                        <x-input-label for="statut" value="Statut" />
                        <select name="statut" id="statut" class="form-select mt-1" required>
                            @foreach (\App\Models\Commande::STATUTS as $valeur => $libelle)
                                <option value="{{ $valeur }}" @selected(old('statut', 'en_attente') === $valeur)>{{ $libelle }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <x-input-label for="adresse_livraison" value="Adresse de livraison" />
                    <x-text-input id="adresse_livraison" name="adresse_livraison" type="text" class="mt-1" :value="old('adresse_livraison')" required />
                    <x-input-error :messages="$errors->get('adresse_livraison')" class="mt-1" />
                </div>

                <div class="mb-3">
                    <x-input-label value="Produits de la commande" />
                    <p class="text-muted small mb-2">Indiquez une quantité (supérieure à 0) pour chaque produit à inclure.</p>
                    <x-input-error :messages="$errors->get('quantites')" class="mt-1" />

                    <div class="table-responsive border rounded">
                        <table class="table mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Prix</th>
                                    <th style="width: 140px;">Quantité</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produits as $produit)
                                    <tr>
                                        <td>{{ $produit->nom }}</td>
                                        <td>{{ number_format($produit->prix, 2, ',', ' ') }} €</td>
                                        <td>
                                            <input type="number" min="0" class="form-control form-control-sm"
                                                name="quantites[{{ $produit->id }}]"
                                                value="{{ old('quantites.'.$produit->id, 0) }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <x-primary-button>Créer la commande</x-primary-button>
                    <a href="{{ route('admin.commandes.index') }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection
