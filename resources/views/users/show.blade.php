@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
        <div class="space-x-2">
            <a href="{{ route('users.edit', $user) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Éditer
            </a>
            <a href="{{ route('users.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                Retour
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="p-4 rounded-lg bg-green-50 text-green-800 mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6 space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Nom d'utilisateur</h3>
                <p class="mt-1 text-lg font-medium">{{ $user->name }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Email</h3>
                <p class="mt-1 text-lg font-medium">{{ $user->email }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Prénom</h3>
                <p class="mt-1 text-lg">{{ $user->first_name ?? '-' }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Nom</h3>
                <p class="mt-1 text-lg">{{ $user->last_name ?? '-' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Téléphone</h3>
                <p class="mt-1 text-lg">{{ $user->phone ?? '-' }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Pays</h3>
                <p class="mt-1 text-lg">{{ $user->country ?? '-' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Ville</h3>
                <p class="mt-1 text-lg">{{ $user->city ?? '-' }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Adresse</h3>
                <p class="mt-1 text-lg">{{ $user->address ?? '-' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Mode de création</h3>
                <p class="mt-1">
                    <span class="px-2 py-1 rounded text-sm font-medium
                        {{ $user->created_mode === 'manual' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $user->created_mode }}
                    </span>
                </p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Créé le</h3>
                <p class="mt-1 text-lg">{{ $user->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        @if ($user->creator)
            <div>
                <h3 class="text-sm font-medium text-gray-500">Créé par</h3>
                <p class="mt-1 text-lg">
                    <a href="{{ route('users.show', $user->creator) }}" class="text-blue-600 hover:text-blue-900">
                        {{ $user->creator->name }}
                    </a>
                </p>
            </div>
        @endif

        @if ($user->deleted_at)
            <div class="p-4 rounded-lg bg-yellow-50 text-yellow-800">
                <p class="font-medium mb-2">Cet utilisateur a été supprimé le {{ $user->deleted_at->format('d/m/Y H:i') }}</p>
                <form action="{{ route('users.restore', $user->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Restaurer
                    </button>
                </form>
            </div>
        @else
            <div class="flex gap-2 pt-4">
                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700" onclick="return confirm('Êtes-vous sûr?')">
                        Supprimer
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
