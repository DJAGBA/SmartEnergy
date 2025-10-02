@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4"><i class="fas fa-chart-line"></i> Analyse visuelle des coupures</h1>

    {{-- Graphiques --}}
    <div class="mb-5">
        <h3><i class="fas fa-bolt"></i> Fréquence des coupures par zone</h3>
        <canvas id="frequenceChart" height="100"></canvas>
    </div>

    <div class="mb-5">
        <h3><i class="fas fa-clock"></i> Durée moyenne des coupures</h3>
        <canvas id="dureeChart" height="100"></canvas>
    </div>

    {{-- Retours clients --}}
    <div class="mt-5">
        <h3><i class="fas fa-comments"></i> Retours des utilisateurs</h3>

        @forelse($retours as $fb)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-user"></i> {{ $fb->user->name ?? 'Utilisateur anonyme' }}
                        <span class="text-muted">— {{ $fb->zone->nom ?? 'Zone inconnue' }}</span>
                    </h5>
                    <p class="card-text">
                        <i class="fas fa-star text-warning"></i> {{ $fb->note }}/5<br>
                        <i class="fas fa-quote-left"></i> {{ $fb->message }}
                    </p>
                    <p class="text-end text-muted small">
                        <i class="fas fa-clock"></i> {{ $fb->created_at->format('d/m/Y à H:i') }}
                    </p>
                </div>
            </div>
        @empty
            <p class="text-muted">Aucun retour client enregistré pour le moment.</p>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labels = {!! json_encode($labels) !!};
const frequenceData = {!! json_encode($frequenceData) !!};
const dureeData = {!! json_encode($dureeData) !!};

// Fréquence des coupures
new Chart(document.getElementById('frequenceChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Fréquence des coupures',
            data: frequenceData,
            backgroundColor: 'rgba(255, 99, 132, 0.6)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// Durée moyenne des coupures
new Chart(document.getElementById('dureeChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Durée moyenne (minutes)',
            data: dureeData,
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
@endsection