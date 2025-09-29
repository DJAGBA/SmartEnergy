@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

    {{-- Messages --}}
    @if(session('success'))
        <div id="success-message" class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-md">
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded shadow-md">
            <p class="font-medium">{{ session('error') }}</p>
        </div>
    @endif

    {{-- Filtre --}}
    <form method="GET" action="{{ route('postes.index') }}" class="mb-6 flex items-center gap-4">
        <label for="etat" class="text-sm text-gray-700">Filtrer par état :</label>
        <select name="etat" id="etat" onchange="this.form.submit()" class="border-gray-300 rounded-md shadow-sm">
            <option value="">Tous</option>
            <option value="actif" {{ request('etat') === 'actif' ? 'selected' : '' }}>✅ Actif</option>
            <option value="hors_service" {{ request('etat') === 'hors_service' ? 'selected' : '' }}>⚠️ Hors service</option>
            <option value="en_attente" {{ request('etat') === 'en_attente' ? 'selected' : '' }}>⏳ En attente</option>
        </select>
    </form>

    <div class="bg-white rounded-lg shadow mb-8">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Gestion des postes de transformation</h3>
            <a href="{{ route('postes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition shadow-sm">
                <i class="fas fa-plus mr-2"></i> Nouveau poste
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code poste</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Zone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Agence</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">État</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($postes as $poste)
                        <tr class="hover:bg-gray-50 
                            @if($poste->etat === 'hors_service') bg-red-50 
                            @elseif($poste->etat === 'en_attente') bg-yellow-50 
                            @elseif($poste->etat === 'actif') bg-green-50 
                            @endif">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $poste->code_poste ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                @if($poste->zones->count() > 0)
                                    {{ $poste->zones->pluck('nom')->join(', ') }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                @if($poste->zones->count() > 0)
                                    {{ $poste->zones->first()->agence?->nom ?? '—' }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2 py-1 rounded text-xs font-semibold
                                    @switch($poste->etat)
                                        @case('actif') bg-green-100 text-green-800 @break
                                        @case('hors_service') bg-red-100 text-red-800 @break
                                        @case('en_attente') bg-yellow-100 text-yellow-800 @break
                                        @default bg-gray-100 text-gray-800
                                    @endswitch">
                                    @switch($poste->etat)
                                        @case('actif') ✅ Actif @break
                                        @case('hors_service') ⚠️ Hors service @break
                                        @case('en_attente') ⏳ En attente @break
                                        @default — @break
                                    @endswitch
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-4">
                                    {{-- Détails --}}
                                    <a href="{{ route('postes.show', $poste) }}" class="text-gray-600 hover:text-gray-900" title="Voir les détails">
                                        <i class="fas fa-eye text-gray-500 hover:text-gray-700"></i>
                                    </a>

                                    {{-- Modifier --}}
                                    <a href="{{ route('postes.edit', $poste) }}" class="text-blue-600 hover:text-blue-900" title="Modifier">
                                        <i class="fas fa-pen-to-square"></i>
                                    </a>

                                    {{-- Supprimer : interdit dans tous les cas --}}
                                    <span class="text-gray-400" title="Suppression interdite">
                                        <i class="fas fa-ban"></i>
                                    </span>

                                    {{-- Migration --}}
                                    @if($poste->etat === 'hors_service')
                                        <a href="{{ route('client.migration.form', ['source_poste_id' => $poste->id]) }}"
                                           class="text-indigo-600 hover:text-indigo-900 flex items-center gap-1"
                                           title="Migrer les clients">
                                            <i class="fas fa-share"></i>
                                            <span class="hidden md:inline">Migrer</span>
                                        </a>
                                    @endif

                                    {{-- Signaler une panne --}}
                                    @if($poste->etat === 'actif')
                                        <form method="POST" action="{{ route('postes.changerEtat', $poste) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-yellow-600 hover:text-yellow-800" title="Signaler une panne" 
                                                    onclick="return confirm('Voulez-vous vraiment signaler une panne pour ce poste ?')">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Aucun poste enregistré.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
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
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                setTimeout(() => successMessage.remove(), 500);
            }, 4000);
        }
    });
</script>
@endpush
