<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Boutique électronique') }}</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-light">
        <div class="min-vh-100 d-flex flex-column">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white border-bottom shadow-sm">
                    <div class="container py-3">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-grow-1">
                @if (session('status'))
                    <div class="container mt-3">
                        <div class="alert alert-success">{{ session('status') }}</div>
                    </div>
                @endif

                {{ $slot }}
            </main>

            <footer class="bg-dark text-white-50 py-3 mt-5">
                <div class="container text-center small">
                    &copy; {{ date('Y') }} Boutique électronique — Projet Laravel
                </div>
            </footer>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
