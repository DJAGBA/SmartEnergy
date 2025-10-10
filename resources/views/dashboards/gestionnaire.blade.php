@extends('layouts.app')
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
@if(session('success'))
    <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
        {{ session('success') }}
    </div>
@endif
        {{-- Vue synthétique des coupures --}}
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-semibold mb-4">Vue synthétique des coupures</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-indigo-100 p-4 rounded flex items-center gap-3">
                        <i class="fas fa-calendar-check text-xl text-indigo-700"></i>
                        <div>
                            <h4 class="font-bold text-indigo-700">Planifiées</h4>
                            <p class="text-xl font-semibold">{{ $stats['planifiees'] ?? 0 }}</p>
                        </div>
                    </div>

                    
                    <div class="bg-yellow-100 p-4 rounded flex items-center gap-3">
                        <i class="fas fa-spinner text-xl text-yellow-700 animate-spin"></i>
                        <div>
                            <h4 class="font-bold text-yellow-700">En cours</h4>
                            <p class="text-xl font-semibold">{{ $stats['encours'] ?? 0 }}</p>
                        </div>
                    </div>

                    <div class="bg-green-100 p-4 rounded flex items-center gap-3">
                        <i class="fas fa-check-circle text-xl text-green-700"></i>
                        <div>
                            <h4 class="font-bold text-green-700">Terminées</h4>
                            <p class="text-xl font-semibold">{{ $stats['terminees'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistiques détaillées --}}
        <div class="mt-8 bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 space-y-8">
                <h3 class="text-lg font-semibold mb-4">Statistiques détaillées</h3>

                {{-- Coupures par zone --}}
                <div>
                    <h4 class="font-bold text-gray-700 mb-2">Par zone</h4>
                    <canvas id="barChart" height="120"></canvas>
                </div>

                {{-- Répartition par type de coupure (compact et réduit) --}}
                <div class="bg-white p-4 rounded shadow-sm mb-6">
                    <h4 class="text-sm font-bold text-gray-700 mb-2">Par type de coupure</h4>
                    <div class="max-w-xs mx-auto">
                        <canvas id="pieChart" style="height: 160px;"></canvas>
                    </div>
                </div>

                {{-- Évolution par période --}}
<div class="bg-white p-6 rounded shadow-sm mt-8">
    <h4 class="font-bold text-gray-700 mb-4">Coupures par période</h4>

    @if(empty($stats['periodes']))
        <p class="text-gray-500">Aucune donnée disponible pour le graphique.</p>
    @else
       <canvas id="lineChart" height="120" style="border: 2px solid red;"></canvas>
    @endif
</div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const barChart = new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($stats['zones'])) !!},
            datasets: [{
                label: 'Coupures',
                data: {!! json_encode(array_values($stats['zones'])) !!},
                backgroundColor: 'rgba(99, 102, 241, 0.6)',
                borderColor: 'rgba(99, 102, 241, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });

    const pieChart = new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode(array_keys($stats['types'])) !!},
            datasets: [{
                data: {!! json_encode(array_values($stats['types'])) !!},
                backgroundColor: ['#facc15', '#f87171', '#60a5fa', '#34d399']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 10,
                        font: { size: 11 }
                    }
                }
            }
        }
    });

    @if(!empty($stats['periodes']))
const ctx = document.getElementById('lineChart').getContext('2d');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_keys($stats['periodes'])) !!},
        datasets: [{
            label: 'Coupures',
            data: {!! json_encode(array_values($stats['periodes'])) !!},
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            fill: true,
            tension: 0.3,
            pointRadius: 4,
            pointHoverRadius: 6
        }]
    },
    options: {
        responsive: true,
        scales: {
            x: { title: { display: true, text: 'Mois' }},
            y: { beginAtZero: true, title: { display: true, text: 'Nombre de coupures' }}
        }
    }
});
@endif

</script>
@endsection