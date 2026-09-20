<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Commande #{{ $commande->id }}</h2>
    </x-slot>

    <div class="container py-4">
        <a href="{{ route('commandes.index') }}" class="btn btn-link ps-0">&larr; Mes commandes</a>

        <div class="card mb-4">
            <div class="card-body">
                <p class="mb-1"><strong>Statut :</strong> <span class="badge text-bg-secondary">{{ \App\Models\Commande::STATUTS[$commande->statut] ?? $commande->statut }}</span></p>
                <p class="mb-1"><strong>Date :</strong> {{ $commande->created_at->format('d/m/Y H:i') }}</p>
                <p class="mb-0"><strong>Adresse de livraison :</strong> {{ $commande->adresse_livraison }}</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table bg-white align-middle">
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
</x-app-layout>
