@extends('admin.layout')

@section('titre', 'Commandes')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">Commandes ({{ $commandes->total() }})</h2>
        <a href="{{ route('admin.commandes.create') }}" class="btn btn-primary btn-sm">+ Nouvelle commande</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Statut</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($commandes as $commande)
                        <tr>
                            <td>{{ $commande->id }}</td>
                            <td>{{ $commande->user->name ?? '—' }}</td>
                            <td><span class="badge text-bg-secondary">{{ \App\Models\Commande::STATUTS[$commande->statut] ?? $commande->statut }}</span></td>
                            <td>{{ number_format($commande->total, 2, ',', ' ') }} €</td>
                            <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.commandes.show', $commande) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                                <form method="POST" action="{{ route('admin.commandes.destroy', $commande) }}" class="d-inline" onsubmit="return confirm('Supprimer cette commande ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-3">Aucune commande.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $commandes->links() }}</div>
@endsection
