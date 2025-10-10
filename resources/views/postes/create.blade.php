@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Créer un nouveau poste</h2>

    {{-- Messages --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('postes.store') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Code du poste --}}
        <div>
            <label class="block font-medium">
                Code du poste <span class="text-red-600">*</span>
                <span class="text-gray-500 text-sm">(généré automatiquement)</span>
            </label>
            <input type="text" value="{{ $codePoste ?? 'sera généré automatiquement' }}" readonly
                   class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-800 font-semibold">
        </div>

        {{-- Agence --}}
        <div>
            <label for="agence_id" class="block font-medium">
                Agence <span class="text-red-600">*</span>
            </label>
            <select name="agence_id" id="agence_id" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Sélectionner une agence --</option>
                @foreach($agences as $agence)
                    <option value="{{ $agence->id }}">{{ $agence->nom }}</option>
                @endforeach
            </select>
        </div>

        {{-- Zones (plusieurs) --}}
        <div>
            <label for="zone_id" class="block font-medium">
                Zones associées <span class="text-red-600">*</span>
            </label>
            <select name="zone_id[]" id="zone_id" multiple required
                    class="w-full border rounded px-3 py-2">
                <option value="">-- Sélectionner une ou plusieurs zones --</option>
            </select>
            <small class="text-gray-500">Maintenez Ctrl (Windows) ou Cmd (Mac) pour sélectionner plusieurs zones.</small>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Enregistrer le poste
        </button>

        <p class="text-sm text-gray-500 mt-2"><span class="text-red-600">*</span> Champs obligatoires</p>
    </form>
</div>

{{-- Script AJAX pour charger les zones selon l’agence --}}
<script>
document.getElementById('agence_id').addEventListener('change', function () {
    const agenceId = this.value;
    const zoneSelect = document.getElementById('zone_id');
    zoneSelect.innerHTML = '<option value="">Chargement...</option>';

    if (!agenceId) {
        zoneSelect.innerHTML = '<option value="">-- Sélectionner une ou plusieurs zones --</option>';
        return;
    }

    fetch(`/agences/${agenceId}/zones`)
        .then(res => res.json())
        .then(data => {
            zoneSelect.innerHTML = '';
            if(data.length === 0){
                zoneSelect.innerHTML = '<option value="">Aucune zone disponible</option>';
                return;
            }
            data.forEach(zone => {
                const option = document.createElement('option');
                option.value = zone.id;
                option.textContent = zone.nom;
                zoneSelect.appendChild(option);
            });
        })
        .catch(() => {
            zoneSelect.innerHTML = '<option value="">Erreur de chargement</option>';
        });
});
</script>
@endsection