@extends('admin.layout')

@section('titre', 'Utilisateurs')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">Utilisateurs ({{ $users->total() }})</h2>
        <a href="{{ route('admin.utilisateurs.create') }}" class="btn btn-primary btn-sm">+ Nouvel utilisateur</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>E-mail</th>
                        <th>Rôle</th>
                        <th>Inscrit le</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->isAdmin())
                                    <span class="badge text-bg-dark">Admin</span>
                                @else
                                    <span class="badge text-bg-secondary">Client</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.utilisateurs.edit', $user) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                                <form method="POST" action="{{ route('admin.utilisateurs.destroy', $user) }}" class="d-inline" onsubmit="return confirm('Supprimer cet utilisateur ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-3">Aucun utilisateur.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $users->links() }}</div>
@endsection
