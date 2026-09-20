<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Valider ma commande</h2>
    </x-slot>

    <div class="container py-4">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="table-responsive">
                    <table class="table bg-white align-middle">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Prix</th>
                                <th>Qté</th>
                                <th>Sous-total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lignes as $ligne)
                                <tr>
                                    <td>{{ $ligne['produit']->nom }}</td>
                                    <td>{{ number_format($ligne['produit']->prix, 2, ',', ' ') }} €</td>
                                    <td>{{ $ligne['quantite'] }}</td>
                                    <td>{{ number_format($ligne['sous_total'], 2, ',', ' ') }} €</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total</th>
                                <th>{{ number_format($total, 2, ',', ' ') }} €</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <h3 class="h5 mb-3">Livraison</h3>

                        <form method="POST" action="{{ route('commandes.store') }}">
                            @csrf

                            <div class="mb-3">
                                <x-input-label for="adresse_livraison" value="Adresse de livraison" />
                                <x-text-input id="adresse_livraison" name="adresse_livraison" type="text" class="mt-1 w-100" :value="old('adresse_livraison')" required autofocus />
                                <x-input-error :messages="$errors->get('adresse_livraison')" class="mt-1" />
                            </div>

                            <x-primary-button class="w-100">Confirmer la commande</x-primary-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
