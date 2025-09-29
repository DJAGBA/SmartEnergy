@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Détails du poste : {{ $poste->code_poste }}
    </h2>
@endsection

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8 bg-white rounded shadow">
    <div class="space-y-4 text-gray-800 text-sm">
        <div><strong>Code :</strong> {{ $poste->code_poste ?? '—' }}</div>
        <div><strong>Zone :</strong> {{ $poste->zone?->first()?->nom ?? '—' }}</div>
        <div><strong>Agence :</strong> {{ $poste->zone?->first()?->agence?->nom ?? '—' }}</div>
        <div><strong>État :</strong> {{ $poste->etat ?? '—' }}</div>

        @if($poste->clients && $poste->clients->count())
            <div class="mt-6">
                <h3 class="text-md font-semibold mb-2">Clients associés :</h3>
                <ul class="list-disc ml-6">
                    @foreach($poste->clients as $client)
                        <li>{{ $client->nom }} ({{ $client->code_client }})</li>
                    @endforeach
                </ul>
            </div>
        @else
            <p class="mt-6 text-gray-500">Aucun client associé à ce poste.</p>
        @endif
    </div>

    {{-- Bouton de retour --}}
    <div class="mt-8">
        <a href="{{ route('postes.index') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">
            <i class="fas fa-arrow-left mr-2"></i> Retour à la liste
        </a>
    </div>
</div>
@endsection
