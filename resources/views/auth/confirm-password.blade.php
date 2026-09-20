<x-guest-layout>
    <div class="mb-3 small text-muted">
        Ceci est une zone sécurisée. Merci de confirmer votre mot de passe avant de continuer.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-3">
            <x-input-label for="password" value="Mot de passe" />
            <x-text-input id="password" class="mt-1" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div class="d-flex justify-content-end">
            <x-primary-button>Confirmer</x-primary-button>
        </div>
    </form>
</x-guest-layout>
