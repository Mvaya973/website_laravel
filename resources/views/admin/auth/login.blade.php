<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Connexion admin — {{ config('app.name', 'Boutique électronique') }}</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-dark">
        <div class="d-flex align-items-center justify-content-center min-vh-100">
            <div class="card shadow-sm" style="width: 100%; max-width: 380px;">
                <div class="card-body p-4">
                    <h1 class="h4 mb-3 text-center">Connexion administrateur</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger py-2 small">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse e-mail</label>
                            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input id="password" type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input id="remember" type="checkbox" name="remember" class="form-check-input">
                            <label for="remember" class="form-check-label">Se souvenir de moi</label>
                        </div>

                        <button type="submit" class="btn btn-dark w-100">Se connecter</button>
                    </form>

                    <p class="text-center small text-muted mt-3 mb-0">
                        <a href="{{ route('home') }}">&larr; Retour au site</a>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
