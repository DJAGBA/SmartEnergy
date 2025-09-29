@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Modifier la coupure</h2>

    <form action="{{ route('coupures.update', $coupure->id) }}" method="POST" class="space-y-6 bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        {{-- mêmes champs que dans create.blade.php, mais préremplis --}}
        <input type="datetime-local" name="date_debut" value="{{ $coupure->date_debut->format('Y-m-d\TH:i') }}" required class="form-input w-full">
        <input type="datetime-local" name="date_fin" value="{{ $coupure->date_fin->format('Y-m-d\TH:i') }}" required class="form-input w-full">
        <input type="number" name="duree_prevue" value="{{ $coupure->duree_prevue }}" required class="form-input w-full">
        <select name="zone_id" required class="form-select w-full">
            @foreach($zones as $zone)
                <option value="{{ $zone->id }}" @selected($zone->id == $coupure->zone_id)>{{ $zone->nom }}</option>
            @endforeach
        </select>
        <textarea name="motif" required class="form-textarea w-full">{{ $coupure->motif }}</textarea>
        <select name="priorite" required class="form-select w-full">
            <option value="faible" @selected($coupure->priorite == 'faible')>Faible</option>
            <option value="moyenne" @selected($coupure->priorite == 'moyenne')>Moyenne</option>
            <option value="élevée" @selected($coupure->priorite == 'élevée')>Élevée</option>
        </select>

        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
            Mettre à jour
        </button>
    </form>
</div>
@endsection