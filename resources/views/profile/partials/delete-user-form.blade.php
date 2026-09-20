<section>
    <header class="mb-3">
        <h3 class="h5">Supprimer le compte</h3>
        <p class="text-muted small mb-0">
            Une fois votre compte supprimé, toutes ses données seront définitivement effacées.
            Téléchargez au préalable toute information que vous souhaitez conserver.
        </p>
    </header>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm-user-deletion">
        Supprimer le compte
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()">
        <form method="post" action="{{ route('profile.destroy') }}" class="p-3">
            @csrf
            @method('delete')

            <h3 class="h5" id="confirm-user-deletion-label">
                Êtes-vous sûr de vouloir supprimer votre compte ?
            </h3>

            <p class="text-muted small">
                Une fois votre compte supprimé, toutes ses données seront définitivement effacées.
                Entrez votre mot de passe pour confirmer la suppression.
            </p>

            <div class="mb-3">
                <x-input-label for="password" value="Mot de passe" class="visually-hidden" />
                <x-text-input id="password" name="password" type="password" class="mt-1" placeholder="Mot de passe" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1" />
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Annuler
                </button>

                <x-danger-button>Supprimer le compte</x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
