<x-app-layout>
    <div class="container py-5">
        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm mb-4">&larr; Retour au catalogue</a>

        <div class="row g-4">
            <div class="col-md-5">
                @if ($produit->image)
                    <img src="{{ asset('storage/'.$produit->image) }}" alt="{{ $produit->nom }}" class="img-fluid rounded shadow-sm">
                @else
                    <div class="bg-secondary bg-opacity-10 rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                        <span class="text-muted">Pas d'image</span>
                    </div>
                @endif
            </div>

            <div class="col-md-7">
                <h1 class="h3">{{ $produit->nom }}</h1>

                <div class="mb-3">
                    @foreach ($produit->categories as $cat)
                        <span class="badge bg-secondary">{{ $cat->nom }}</span>
                    @endforeach
                </div>

                <p class="text-muted">{{ $produit->description }}</p>

                <p class="fs-3 fw-bold text-primary">{{ number_format($produit->prix, 2, ',', ' ') }} €</p>

                @if ($produit->stock < 1)
                    <span class="badge bg-secondary">Rupture de stock</span>
                @else
                    <p class="text-success small">{{ $produit->stock }} en stock</p>

                    <form method="POST" action="{{ route('panier.ajouter', $produit) }}" class="row g-2 align-items-end" style="max-width: 320px;">
                        @csrf
                        <div class="col-auto">
                            <label for="qte" class="form-label small">Quantité</label>
                            <input type="number" id="qte" name="qte" value="1" min="1" max="{{ $produit->stock }}" class="form-control">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
