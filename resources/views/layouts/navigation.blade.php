<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            🛒 Boutique électronique
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Basculer la navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                    Accueil
                </x-nav-link>
                <x-nav-link :href="route('panier.index')" :active="request()->routeIs('panier.*')">
                    Panier
                </x-nav-link>
                @auth
                    <x-nav-link :href="route('commandes.index')" :active="request()->routeIs('commandes.*')">
                        Mes commandes
                    </x-nav-link>
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto align-items-md-center gap-md-2">
                @auth
                    <li class="nav-item dropdown">
                        <x-dropdown align="right">
                            <x-slot name="trigger">
                                <span class="nav-link">
                                    {{ Auth::user()->name }} ▾
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    Mon profil
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('commandes.index')">
                                    Mes commandes
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                        Se déconnecter
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Se connecter</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm" href="{{ route('register') }}">S'inscrire</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
