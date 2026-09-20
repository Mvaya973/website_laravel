<x-app-layout>
    <div class="container py-5">

        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('home') }}" class="row g-2 align-items-end">
                    <div class="col-auto flex-grow-1">
                        <label for="cat" class="form-label">Filtrer par catégorie :</label>
                        <select name="cat" id="cat" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Toutes les catégories --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" @selected($selectedCategory == $cat->id)>
                                    {{ $cat->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if ($selectedCategory)
                        <div class="col-auto">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">Réinitialiser</a>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <h2 class="mb-4">Produits disponibles</h2>

        <div class="row g-4">
            @forelse ($products as $p)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        @if ($p->image)
                            <img src="{{ asset('storage/'.$p->image) }}" class="card-img-top" alt="{{ $p->nom }}" style="height: 180px; object-fit: cover;">
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h3 class="card-title h5">
                                <a href="{{ route('produits.show', $p) }}" class="text-decoration-none text-dark">
                                    {{ $p->nom }}
                                </a>
                            </h3>

                            <p class="card-text text-muted small flex-grow-1">
                                {{ \Illuminate\Support\Str::limit($p->description, 100) }}
                            </p>

                            <p class="fs-4 fw-bold text-primary">
                                {{ number_format($p->prix, 2, ',', ' ') }} €
                            </p>

                            @if ($p->stock < 1)
                                <span class="badge bg-secondary mb-2">Rupture de stock</span>
                            @else
                                <form method="POST" action="{{ route('panier.ajouter', $p) }}">
                                    @csrf

                                    <div class="mb-2">
                                        <label for="qte-{{ $p->id }}" class="form-label small">Quantité</label>
                                        <input type="number" id="qte-{{ $p->id }}" name="qte" value="1" min="1" max="{{ $p->stock }}" class="form-control form-control-sm">
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">
                                        Ajouter au panier
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning">
                        Aucun produit trouvé dans cette catégorie.
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>
