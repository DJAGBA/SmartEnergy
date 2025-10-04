@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h2 class="text-xl font-semibold text-gray-800 mb-6">Migration des clients du poste défectueux</h2>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <p class="mb-4 text-gray-700">Poste défectueux : <strong>{{ $sourcePoste->nom }}</strong></p>
        <p class="mb-2 text-gray-600">Clients concernés : {{ $clients->count() }}</p>

        <form method="POST" action="{{ route('client.migration.execute', $sourcePoste->id) }}">
            @csrf

            <label for="destination_poste_id" class="block text-sm font-medium text-gray-700 mb-1">
                Choisir le poste de destination
            </label>

            <select name="destination_poste_id" id="destination_poste_id" required class="form-select w-full mb-4">
                <optgroup label="Postes actifs">
                    @foreach($postesCibles->where('etat', 'actif') as $poste)
                        <option value="{{ $poste->id }}">
                            {{ $poste->nom }} ({{ $poste->zones->pluck('nom')->join(', ') }})
                        </option>
                    @endforeach
                </optgroup>
                <optgroup label="Postes en attente">
                    @foreach($postesCibles->where('etat', 'en_attente') as $poste)
                        <option value="{{ $poste->id }}">
                            {{ $poste->nom }} ({{ $poste->zones->pluck('nom')->join(', ') }})
                        </option>
                    @endforeach
                </optgroup>
            </select>

            <button type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                Migrer les clients
            </button>
        </form>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-800 mb-4">Liste des clients à migrer</h3>
        <ul class="list-disc pl-5 text-gray-700">
            @forelse($clients as $client)
                <li>{{ $client->nom }} (ID: {{ $client->id }})</li>
            @empty
                <li>Aucun client à migrer.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection