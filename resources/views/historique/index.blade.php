@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Historique des postes créés</h2>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date de création</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Zones</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Agences</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($postes as $poste)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $poste->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $poste->zones->pluck('nom')->join(', ') ?: '—' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $poste->zones->pluck('agence.nom')->unique()->join(', ') ?: '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">Aucun poste enregistré.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination minimaliste --}}
    @if ($postes->hasPages())
        <div class="flex justify-between items-center px-6 py-4 border-t border-gray-200 text-sm">
            @if ($postes->onFirstPage())
                <span class="text-gray-400">← Précédent</span>
            @else
                <a href="{{ $postes->previousPageUrl() }}" class="text-blue-600 hover:underline">← Précédent</a>
            @endif

            <span class="text-gray-600">Page {{ $postes->currentPage() }} sur {{ $postes->lastPage() }}</span>

            @if ($postes->hasMorePages())
                <a href="{{ $postes->nextPageUrl() }}" class="text-blue-600 hover:underline">Suivant →</a>
            @else
                <span class="text-gray-400">Suivant →</span>
            @endif
        </div>
    @endif

    <div class="mt-8 flex justify-end gap-3">
        <a href="{{ route('historique.export.pdf') }}"
           class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
            <i class="fas fa-file-pdf"></i>

            Exporter en PDF
        </a>

        <a href="{{ route('historique.export.excel') }}"
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
            <i class="fas fa-file-excel"></i>

            Exporter en Excel
        </a>
    </div>

</div>
@endsection
