@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10">
    {{-- Titre + date + bouton --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Coupures planifiées</h2>
            <p class="text-sm text-gray-500">Aujourd’hui : {{ now()->format('d/m/Y') }}</p>
        </div>
        <a href="{{ route('coupures.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 flex items-center gap-2">
            <i class="fas fa-calendar-plus"></i>
            <span>Créer une coupure</span>
        </a>
    </div>

    {{-- Tableau --}}
    <table class="min-w-full bg-white rounded shadow overflow-hidden">
        <thead>
            <tr class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                <th class="px-4 py-2">Début</th>
                <th class="px-4 py-2">Fin</th>
                <th class="px-4 py-2">Durée</th>
                <th class="px-4 py-2">Zone</th>
                <th class="px-4 py-2">Motif</th>
                <th class="px-4 py-2">Priorité</th>
                <th class="px-4 py-2">Statut</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($coupures as $coupure)
                <tr class="border-t text-sm">
                    <td class="px-4 py-2">
                        {{ \Carbon\Carbon::parse($coupure->date_debut)->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-4 py-2">
                        {{ \Carbon\Carbon::parse($coupure->date_fin)->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-4 py-2">
                        @php
                            $minutes = $coupure->duree_prevue ?? 0;
                            $heures = intdiv($minutes, 60);
                            $reste = $minutes % 60;
                        @endphp
                        {{ $heures > 0 ? $heures . 'h ' : '' }}{{ $reste }}min
                    </td>
                    <td class="px-4 py-2">
                        {{ optional($coupure->zone)->nom ?? 'Zone inconnue' }}
                    </td>
                    <td class="px-4 py-2">{{ $coupure->motif }}</td>
                    <td class="px-4 py-2">{{ ucfirst($coupure->priorite) }}</td>
                    <td class="px-4 py-2">
                        @php
                            $now = now();
                            $debut = \Carbon\Carbon::parse($coupure->date_debut);
                            $fin = \Carbon\Carbon::parse($coupure->date_fin);
                        @endphp
                        @if($debut->isFuture())
                            <span class="text-yellow-600 font-semibold">À venir</span>
                        @elseif($now->between($debut, $fin))
                            <span class="text-green-600 font-semibold">En cours</span>
                        @else
                            <span class="text-gray-500">Terminée</span>
                        @endif
                    </td>
                   <td class="px-4 py-2 flex gap-4 items-center">
    <a href="{{ route('coupures.edit', $coupure->id) }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
        <i class="fas fa-edit"></i>
        <span>Modifier</span>
    </a>
    <form action="{{ route('coupures.destroy', $coupure->id) }}" method="POST" onsubmit="return confirm('Supprimer cette coupure ?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:text-red-800 flex items-center gap-1">
            <i class="fas fa-trash-alt"></i>
            <span>Supprimer</span>
        </button>
    </form>
</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-4 py-4 text-center text-gray-500">Aucune coupure planifiée pour le moment.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $coupures->links() }}
    </div>
</div>
@endsection