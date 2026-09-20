@extends('admin.layout')

@section('titre', 'Catégories')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">Catégories ({{ $categories->total() }})</h2>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">+ Nouvelle catégorie</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Produits</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $categorie)
                        <tr>
                            <td>{{ $categorie->id }}</td>
                            <td>{{ $categorie->nom }}</td>
                            <td>{{ $categorie->produits_count }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.categories.edit', $categorie) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $categorie) }}" class="d-inline" onsubmit="return confirm('Supprimer cette catégorie ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">Aucune catégorie.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $categories->links() }}</div>
@endsection
