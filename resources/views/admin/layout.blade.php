<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin — {{ config('app.name', 'Boutique électronique') }}</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">
        <div class="d-flex" style="min-height: 100vh;">
            <nav class="bg-dark text-white p-3" style="width: 240px; flex-shrink: 0;">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none d-block mb-4 fw-semibold fs-5">
                    Espace admin
                </a>

                <ul class="nav nav-pills flex-column gap-1">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-white' }}">
                            Tableau de bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.produits.index') }}" class="nav-link {{ request()->routeIs('admin.produits.*') ? 'active' : 'text-white' }}">
                            Produits
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : 'text-white' }}">
                            Catégories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.commandes.index') }}" class="nav-link {{ request()->routeIs('admin.commandes.*') ? 'active' : 'text-white' }}">
                            Commandes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.utilisateurs.index') }}" class="nav-link {{ request()->routeIs('admin.utilisateurs.*') ? 'active' : 'text-white' }}">
                            Utilisateurs
                        </a>
                    </li>
                </ul>

                <hr class="text-white-50">

                <a href="{{ route('home') }}" class="d-block text-white-50 small mb-2 text-decoration-none">
                    &larr; Retour au site
                </a>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light w-100">Se déconnecter</button>
                </form>
            </nav>

            <div class="flex-grow-1">
                <div class="bg-white border-bottom px-4 py-3 d-flex justify-content-between align-items-center">
                    <h1 class="h5 mb-0">@yield('titre', 'Administration')</h1>
                    <span class="text-muted small">{{ Auth::guard('admin')->user()->name ?? '' }}</span>
                </div>

                <div class="p-4">
                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
