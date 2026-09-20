<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Mon panier</h2>
    </x-slot>

    <div class="container py-4">
        @if ($lignes->isEmpty())
            <div class="alert alert-info">
                Votre panier est vide. <a href="{{ route('home') }}">Voir le catalogue</a>.
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle bg-white">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Prix unitaire</th>
                            <th style="width: 160px;">Quantité</th>
                            <th>Sous-total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lignes as $ligne)
                            <tr>
                                <td>
                                    <a href="{{ route('produits.show', $ligne['produit']) }}" class="text-decoration-none">
                                        {{ $ligne['produit']->nom }}
                                    </a>
                                </td>
                                <td>{{ number_format($ligne['produit']->prix, 2, ',', ' ') }} €</td>
                                <td>
                                    <form method="POST" action="{{ route('panier.maj', $ligne['produit']) }}" class="d-flex gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="qte" value="{{ $ligne['quantite'] }}" min="1" max="{{ $ligne['produit']->stock }}" class="form-control form-control-sm">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">OK</button>
                                    </form>
                                </td>
                                <td class="fw-semibold">{{ number_format($ligne['sous_total'], 2, ',', ' ') }} €</td>
                                <td>
                                    <form method="POST" action="{{ route('panier.retirer', $ligne['produit']) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Retirer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total</th>
                            <th colspan="2">{{ number_format($total, 2, ',', ' ') }} €</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="d-flex justify-content-between">
                <form method="POST" action="{{ route('panier.vider') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">Vider le panier</button>
                </form>

                @auth
                    <a href="{{ route('commandes.create') }}" class="btn btn-primary">Passer la commande</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Se connecter pour commander</a>
                @endauth
            </div>
        @endif
    </div>
</x-app-layout>
