@extends('admin.layout')

@section('titre', 'Tableau de bord')

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <div class="display-6">{{ $nbUtilisateurs }}</div>
                    <div class="text-muted small">Utilisateurs</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <div class="display-6">{{ $nbProduits }}</div>
                    <div class="text-muted small">Produits</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <div class="display-6">{{ $nbCategories }}</div>
                    <div class="text-muted small">Catégories</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <div class="display-6">{{ $nbCommandes }}</div>
                    <div class="text-muted small">Commandes</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Dernières commandes</div>
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Statut</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dernieresCommandes as $commande)
                        <tr>
                            <td>{{ $commande->id }}</td>
                            <td>{{ $commande->user->name ?? '—' }}</td>
                            <td><span class="badge text-bg-secondary">{{ \App\Models\Commande::STATUTS[$commande->statut] ?? $commande->statut }}</span></td>
                            <td>{{ number_format($commande->total, 2, ',', ' ') }} €</td>
                            <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                            <td><a href="{{ route('admin.commandes.show', $commande) }}" class="btn btn-sm btn-outline-primary">Voir</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-3">Aucune commande pour le moment.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
