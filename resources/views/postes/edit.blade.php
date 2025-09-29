@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Modifier le poste</h2>

    <form action="{{ route('postes.update', $poste) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        {{-- Code poste --}}
        <div>
            <label for="code_poste" class="block font-medium">Code du poste</label>
            <input type="text" name="code_poste" id="code_poste" value="{{ $poste->code_poste }}" required class="w-full border rounded px-3 py-2">
        </div>

        {{-- Zones (multiple si needed) --}}
        <div>
            <label for="zones" class="block font-medium">Zones</label>
            <select name="zones[]" id="zones" multiple class="w-full border rounded px-3 py-2">
                @foreach($zones as $zone)
                    <option value="{{ $zone->id }}"
                        @if($poste->zone->contains($zone->id)) selected @endif>
                        {{ $zone->nom }}
                    </option>
                @endforeach
            </select>
            <p class="text-sm text-gray-500 mt-1">Maintenez Ctrl (Windows) ou Cmd (Mac) pour sélectionner plusieurs zones.</p>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Mettre à jour
        </button>
    </form>
</div>
@endsection
