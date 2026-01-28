@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold">Utilisateurs</h1>
        <a href="{{ route('users.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Ajouter un utilisateur
        </a>
    </div>

    @if (session('success'))
        <div class="p-4 rounded-lg bg-green-50 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Nom</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Prénom</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Nom</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Téléphone</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Ville</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Mode de création</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->first_name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->last_name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->phone ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->city ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 rounded text-xs font-medium
                                {{ $user->created_mode === 'manual' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $user->created_mode }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="{{ route('users.show', $user) }}" class="text-blue-600 hover:text-blue-900">Voir</a>
                            <a href="{{ route('users.edit', $user) }}" class="text-green-600 hover:text-green-900">Éditer</a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">Aucun utilisateur trouvé</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection
