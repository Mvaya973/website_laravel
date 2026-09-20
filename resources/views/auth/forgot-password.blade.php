<x-guest-layout>
    <h1 class="h4 mb-3">Mot de passe oublié</h1>

    <div class="mb-3 small text-muted">
        Indiquez votre adresse e-mail : nous vous enverrons un lien pour réinitialiser votre mot de passe.
    </div>

    <x-auth-session-status class="mb-3" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <x-input-label for="email" value="Adresse e-mail" />
            <x-text-input id="email" class="mt-1" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div class="d-flex justify-content-end">
            <x-primary-button>
                Envoyer le lien de réinitialisation
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
