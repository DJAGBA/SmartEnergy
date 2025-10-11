@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Planifier une coupure</h2>

    <form action="{{ route('coupures.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded shadow">
        @csrf

        {{-- Date et heure de début --}}
        <div>
            <label for="date_debut" class="block font-semibold text-gray-700">
                Date et heure de début <span class="text-red-600">*</span>
            </label>
            <input type="datetime-local" name="date_debut" id="date_debut"
                   min="{{ now()->format('Y-m-d\TH:i') }}"
                   required class="form-input w-full mt-1">
        </div>

        {{-- Date et heure de fin --}}
        <div>
            <label for="date_fin" class="block font-semibold text-gray-700">
                Date et heure de fin <span class="text-red-600">*</span>
            </label>
            <input type="datetime-local" name="date_fin" id="date_fin"
                   min="{{ now()->format('Y-m-d\TH:i') }}"
                   required class="form-input w-full mt-1">
        </div>

        {{-- Zone concernée --}}
        <div>
            <label for="zone_id" class="block font-semibold text-gray-700">
                Zone concernée <span class="text-red-600">*</span>
            </label>
            <select name="zone_id" id="zone_id" required class="form-select w-full mt-1">
                <option value="">-- Sélectionner une zone --</option>
                @foreach($zones as $zone)
                    <option value="{{ $zone->id }}">{{ $zone->nom }}</option>
                @endforeach
            </select>
        </div>

        {{-- Postes liés à la zone --}}
        <div id="postes-container" class="hidden">
            <label class="block font-semibold text-gray-700 mb-2">
                Postes concernés (sélection facultative)
            </label>
            <div id="postes-list" class="space-y-4"></div>
        </div>

        {{-- Motif --}}
        <div>
            <label for="motif" class="block font-semibold text-gray-700">
                Motif <span class="text-red-600">*</span>
            </label>
            <textarea name="motif" id="motif" rows="3" required class="form-textarea w-full mt-1"></textarea>
        </div>

        {{-- Priorité --}}
        <div>
            <label for="priorite" class="block font-semibold text-gray-700">
                Niveau de priorité <span class="text-red-600">*</span>
            </label>
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
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('bg-gray-50', 'p-3', 'rounded', 'border', 'border-gray-200');

                    const posteLabel = document.createElement('label');
                    posteLabel.classList.add('block', 'font-semibold', 'text-gray-700', 'mb-2');
                    posteLabel.innerHTML = `${poste.code_poste}`;

                    const radioGroup = document.createElement('div');
                    radioGroup.classList.add('flex', 'items-center', 'gap-6');

                    const inclureWrapper = document.createElement('label');
                    inclureWrapper.classList.add('flex', 'items-center', 'gap-2');
                    const inclureRadio = document.createElement('input');
                    inclureRadio.type = 'radio';
                    inclureRadio.name = `choix[${poste.id}]`;
                    inclureRadio.value = 'inclure';
                    inclureRadio.classList.add('form-radio', 'text-indigo-600');
                    inclureWrapper.appendChild(inclureRadio);
                    inclureWrapper.appendChild(document.createTextNode('Inclure dans la coupure'));

                    const signalerWrapper = document.createElement('label');
                    signalerWrapper.classList.add('flex', 'items-center', 'gap-2');
                    const signalerRadio = document.createElement('input');
                    signalerRadio.type = 'radio';
                    signalerRadio.name = `choix[${poste.id}]`;
                    signalerRadio.value = 'signaler';
                    signalerRadio.classList.add('form-radio', 'text-red-600');
                    signalerWrapper.appendChild(signalerRadio);
                    signalerWrapper.appendChild(document.createTextNode('Signaler comme problématique'));

                    radioGroup.appendChild(inclureWrapper);
                    radioGroup.appendChild(signalerWrapper);

                    const messageInput = document.createElement('textarea');
                    messageInput.name = `message[${poste.id}]`;
                    messageInput.rows = 2;
                    messageInput.placeholder = 'Message de signalement...';
                    messageInput.classList.add('form-textarea', 'mt-2', 'w-full', 'hidden');

                    signalerRadio.addEventListener('change', () => {
                        messageInput.classList.remove('hidden');
                    });
                    inclureRadio.addEventListener('change', () => {
                        messageInput.classList.add('hidden');
                    });

                    wrapper.appendChild(posteLabel);
                    wrapper.appendChild(radioGroup);
                    wrapper.appendChild(messageInput);

                    list.appendChild(wrapper);
                });
            }
            container.classList.remove('hidden');
        });
});
</script>
@endsection