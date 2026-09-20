<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Mes commandes</h2>
    </x-slot>

    <div class="container py-4">
        @if ($commandes->isEmpty())
            <div class="alert alert-info">
                Vous n'avez pas encore passé de commande. <a href="{{ route('home') }}">Voir le catalogue</a>.
            </div>
        @else
            <div class="table-responsive">
                <table class="table bg-white align-middle">
                    <thead>
                        <tr>
                            <th>Commande</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($commandes as $commande)
                            <tr>
                                <td>#{{ $commande->id }}</td>
                                <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                                <td><span class="badge text-bg-secondary">{{ \App\Models\Commande::STATUTS[$commande->statut] ?? $commande->statut }}</span></td>
                                <td>{{ number_format($commande->total, 2, ',', ' ') }} €</td>
                                <td>
                                    <a href="{{ route('commandes.show', $commande) }}" class="btn btn-sm btn-outline-primary">Détails</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $commandes->links() }}
        @endif
    </div>
</x-app-layout>
