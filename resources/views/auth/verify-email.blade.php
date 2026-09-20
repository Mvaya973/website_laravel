<x-guest-layout>
    <div class="mb-3 small text-muted">
        Merci de votre inscription ! Avant de commencer, pouvez-vous confirmer votre adresse e-mail en
        cliquant sur le lien que nous venons de vous envoyer ? Si vous n'avez rien reçu, nous pouvons
        vous en renvoyer un.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success py-2">
            Un nouveau lien de vérification a été envoyé à l'adresse e-mail fournie lors de l'inscription.
        </div>
    @endif

    <div class="d-flex align-items-center justify-content-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>Renvoyer l'e-mail de vérification</x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link btn-sm text-decoration-none">
                Se déconnecter
            </button>
        </form>
    </div>
</x-guest-layout>
