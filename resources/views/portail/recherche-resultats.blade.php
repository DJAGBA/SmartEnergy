@extends('layouts.app')

@section('content')
<section class="section" id="resultats">
    <h2 class="section-title">Résultats de la recherche</h2>

    @forelse($coupures as $coupure)
        <div class="bg-white rounded p-4 text-black space-y-2">
            <div class="font-semibold text-base">{{ $coupure->zone->nom ?? 'Zone inconnue' }}</div>
            <div><strong>Date :</strong> {{ \Carbon\Carbon::parse($coupure->date_debut)->format('d/m/Y') }}</div>
            <div><strong>Heure :</strong> {{ \Carbon\Carbon::parse($coupure->date_debut)->format('H\h') }} à {{ \Carbon\Carbon::parse($coupure->date_fin)->format('H\h') }}</div>
            <div><strong>Durée :</strong> {{ \Carbon\Carbon::parse($coupure->date_debut)->diffInMinutes($coupure->date_fin) }} min</div>
            <div><strong>Motif :</strong> {{ ucfirst($coupure->motif) }}</div>

            <form method="GET" action="{{ route('coupures.recherche') }}">
    <input type="text" name="reference" placeholder="Référence client">
    <button type="submit">Rechercher</button>
</form>
        </div>
    @empty
        <p class="text-black">Aucune coupure trouvée pour ces critères.</p>
    @endforelse
</section>
@endsection