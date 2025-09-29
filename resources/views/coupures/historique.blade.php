@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Historique des coupures</h2>
            <p class="text-sm text-gray-500">Coupures terminées jusqu’à aujourd’hui : {{ now()->format('d/m/Y') }}</p>
        </div>
        <a href="{{ route('coupures.index') }}"
           class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            <span>Retour</span>
        </a>
    </div>

    <table class="min-w-full bg-white rounded shadow overflow-hidden">
        <thead>
            <tr class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                <th class="px-4 py-2">Début</th>
                <th class="px-4 py-2">Fin</th>
                <th class="px-4 py-2">Durée</th>
                <th class="px-4 py-2">Zone</th>
                <th class="px-4 py-2">Motif</th>
                <th class="px-4 py-2">Priorité</th>
                <th class="px-4 py-2">Gestionnaire</th>
            </tr>
        </thead>
        <tbody>
            @forelse($coupures as $coupure)
                <tr class="border-t text-sm">
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($coupure->date_debut)->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($coupure->date_fin)->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-2">
                        @php
                            $minutes = $coupure->duree_prevue ?? 0;
                            $heures = intdiv($minutes, 60);
                            $reste = $minutes % 60;
                        @endphp
                        {{ $heures > 0 ? $heures . 'h ' : '' }}{{ $reste }}min
                    </td>
                    <td class="px-4 py-2">{{ optional($coupure->zone)->nom ?? 'Zone inconnue' }}</td>
                    <td class="px-4 py-2">{{ $coupure->motif }}</td>
                    <td class="px-4 py-2">{{ ucfirst($coupure->priorite) }}</td>
                    <td class="px-4 py-2">{{ optional($coupure->gestionnaire)->name ?? 'Non attribué' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-4 text-center text-gray-500">Aucune coupure terminée pour le moment.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-6">
        {{ $coupures->links() }}
    </div>
</div>
<div class="flex justify-end gap-4 mb-4">
   <a href="{{ route('coupures.export.pdf') }}"
   class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 flex items-center gap-2">
    <i class="fas fa-file-pdf"></i>
    <span>Exporter PDF</span>
</a>

<a href="{{ route('coupures.export.excel') }}"
   class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 flex items-center gap-2">
    <i class="fas fa-file-excel"></i>
    <span>Exporter Excel</span>
</a>
</div>
@endsection