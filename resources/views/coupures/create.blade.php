@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Planifier une coupure</h2>

    <form action="{{ route('coupures.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded shadow">
        @csrf

        {{-- Date et heure de début --}}
        <div>
            <label for="date_debut" class="block font-semibold text-gray-700">Date et heure de début</label>
            <input type="datetime-local" name="date_debut" id="date_debut"
                   min="{{ now()->format('Y-m-d\TH:i') }}"
                   required class="form-input w-full mt-1">
        </div>

        {{-- Date et heure de fin --}}
        <div>
            <label for="date_fin" class="block font-semibold text-gray-700">Date et heure de fin</label>
            <input type="datetime-local" name="date_fin" id="date_fin"
                   min="{{ now()->format('Y-m-d\TH:i') }}"
                   required class="form-input w-full mt-1">
        </div>

        {{-- Zone concernée --}}
        <div>
            <label for="zone_id" class="block font-semibold text-gray-700">Zone concernée</label>
            <select name="zone_id" id="zone_id" required class="form-select w-full mt-1">
                <option value="">-- Sélectionner une zone --</option>
                @foreach($zones as $zone)
                    <option value="{{ $zone->id }}">{{ $zone->nom }}</option>
                @endforeach
            </select>
        </div>

        {{-- Postes liés à la zone --}}
        <div id="postes-container" class="hidden">
            <label class="block font-semibold text-gray-700 mb-2">Postes concernés</label>
            <div id="postes-list" class="space-y-2"></div>
        </div>

        {{-- Motif --}}
        <div>
            <label for="motif" class="block font-semibold text-gray-700">Motif</label>
            <textarea name="motif" id="motif" rows="3" required class="form-textarea w-full mt-1"></textarea>
        </div>

        {{-- Priorité --}}
        <div>
            <label for="priorite" class="block font-semibold text-gray-700">Niveau de priorité</label>
            <select name="priorite" id="priorite" required class="form-select w-full mt-1">
                <option value="faible">Faible</option>
                <option value="moyenne">Moyenne</option>
                <option value="élevée">Élevée</option>
            </select>
        </div>

        {{-- Bouton --}}
        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                Enregistrer la coupure
            </button>
        </div>
    </form>
</div>

{{-- Script pour charger les postes liés dynamiquement --}}
<script>
document.getElementById('zone_id').addEventListener('change', function () {
    const zoneId = this.value;
    const container = document.getElementById('postes-container');
    const list = document.getElementById('postes-list');

    if (!zoneId) {
        container.classList.add('hidden');
        list.innerHTML = '';
        return;
    }

    fetch(`/zones/${zoneId}/postes`)
        .then(response => response.json())
        .then(postes => {
            list.innerHTML = '';
            if (postes.length === 0) {
                list.innerHTML = '<p class="text-gray-500">Aucun poste lié à cette zone.</p>';
            } else {
                postes.forEach(poste => {
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = 'postes[]';
                    checkbox.value = poste.id;
                    checkbox.classList.add('mr-2');

                    const label = document.createElement('label');
                    label.classList.add('block', 'text-gray-700');
                    label.appendChild(checkbox);
                    label.appendChild(document.createTextNode(poste.code_poste));

                    list.appendChild(label);
                });
            }
            container.classList.remove('hidden');
        });
});
</script>
@endsection