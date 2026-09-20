@extends('admin.layout')

@section('titre', 'Produits')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">Produits ({{ $produits->total() }})</h2>
        <a href="{{ route('admin.produits.create') }}" class="btn btn-primary btn-sm">+ Nouveau produit</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th></th>
                        <th>Nom</th>
                        <th>Catégories</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produits as $produit)
                        <tr>
                            <td>{{ $produit->id }}</td>
                            <td>
                                @if ($produit->image)
                                    <img src="{{ asset('storage/'.$produit->image) }}" alt="" style="width: 40px; height: 40px; object-fit: cover;" class="rounded">
                                @endif
                            </td>
                            <td>{{ $produit->nom }}</td>
                            <td>
                                @foreach ($produit->categories as $cat)
                                    <span class="badge text-bg-secondary">{{ $cat->nom }}</span>
                                @endforeach
                            </td>
                            <td>{{ number_format($produit->prix, 2, ',', ' ') }} €</td>
                            <td>{{ $produit->stock }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.produits.edit', $produit) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                                <form method="POST" action="{{ route('admin.produits.destroy', $produit) }}" class="d-inline" onsubmit="return confirm('Supprimer ce produit ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-3">Aucun produit.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $produits->links() }}</div>
@endsection
