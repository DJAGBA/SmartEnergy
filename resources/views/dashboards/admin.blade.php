@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Tableau de bord Administrateur
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Liste des utilisateurs</h3>

                    <table class="min-w-full table-auto border border-yellow-200 rounded overflow-hidden">
                        <thead class="bg-yellow-100 text-left text-sm font-semibold text-gray-700">
                            <tr>
                                <th class="px-4 py-2 border-b">Nom</th>
                                <th class="px-4 py-2 border-b">Email</th>
                                <th class="px-4 py-2 border-b">Rôles</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-800">
                            @forelse($stats['utilisateurs'] ?? [] as $user)
                                <tr class="hover:bg-yellow-50">
                                    <td class="px-4 py-2 border-b">{{ $user->name }}</td>
                                    <td class="px-4 py-2 border-b">{{ $user->email }}</td>
                                    <td class="px-4 py-2 border-b">
                                        {{ $user->roles->pluck('name')->join(', ') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-4 text-center text-gray-500">
                                        Aucun utilisateur enregistré pour le moment.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection