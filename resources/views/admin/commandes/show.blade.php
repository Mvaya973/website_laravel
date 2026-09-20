@extends('admin.layout')

@section('titre', 'Commande #' . $commande->id)

@section('content')
    <a href="{{ route('admin.commandes.index') }}" class="btn btn-link ps-0">&larr; Retour aux commandes</a>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">Produits commandés</div>
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Prix unitaire</th>
                                <th>Quantité</th>
                                <th>Sous-total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($commande->produits as $produit)
                                <tr>
                                    <td>{{ $produit->nom }}</td>
                                    <td>{{ number_format($produit->pivot->prix_unitaire, 2, ',', ' ') }} €</td>
                                    <td>{{ $produit->pivot->quantite }}</td>
                                    <td>{{ number_format($produit->pivot->prix_unitaire * $produit->pivot->quantite, 2, ',', ' ') }} €</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total</th>
                                <th>{{ number_format($commande->total, 2, ',', ' ') }} €</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body">
                    <p class="mb-1"><strong>Client :</strong> {{ $commande->user->name ?? '—' }}</p>
                    <p class="mb-1"><strong>E-mail :</strong> {{ $commande->user->email ?? '—' }}</p>
                    <p class="mb-1"><strong>Adresse :</strong> {{ $commande->adresse_livraison }}</p>
                    <p class="mb-0"><strong>Date :</strong> {{ $commande->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.commandes.update', $commande) }}">
                        @csrf
                        @method('PUT')

                        <x-input-label for="statut" value="Statut de la commande" />
                        <select name="statut" id="statut" class="form-select mt-1 mb-3">
                            @foreach (\App\Models\Commande::STATUTS as $valeur => $libelle)
                                <option value="{{ $valeur }}" @selected($commande->statut === $valeur)>{{ $libelle }}</option>
                            @endforeach
                        </select>

                        <x-primary-button class="w-100">Mettre à jour</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
