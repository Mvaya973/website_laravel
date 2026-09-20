@extends('admin.layout')

@section('titre', 'Nouvel utilisateur')

@section('content')
    <div class="card" style="max-width: 560px;">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.utilisateurs.store') }}">
                @csrf

                <div class="mb-3">
                    <x-input-label for="name" value="Nom" />
                    <x-text-input id="name" name="name" type="text" class="mt-1" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <div class="mb-3">
                    <x-input-label for="email" value="Adresse e-mail" />
                    <x-text-input id="email" name="email" type="email" class="mt-1" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <div class="mb-3">
                    <x-input-label for="password" value="Mot de passe" />
                    <x-text-input id="password" name="password" type="password" class="mt-1" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <div class="mb-3">
                    <x-input-label for="password_confirmation" value="Confirmer le mot de passe" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1" required />
                </div>

                <div class="mb-3 form-check">
                    <input id="is_admin" type="checkbox" name="is_admin" value="1" class="form-check-input" {{ old('is_admin') ? 'checked' : '' }}>
                    <label for="is_admin" class="form-check-label">Administrateur</label>
                </div>

                <div class="d-flex gap-2">
                    <x-primary-button>Créer</x-primary-button>
                    <a href="{{ route('admin.utilisateurs.index') }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection
