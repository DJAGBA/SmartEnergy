@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Statistiques principales --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <x-dashboard-card title="Agences" :count="$stats['agences']" color="blue" icon="building" />
            <x-dashboard-card title="Zones" :count="$stats['zones']" color="indigo" icon="map-marker-alt" />
            <x-dashboard-card title="Postes" :count="$stats['postes']" color="green" icon="bolt" />
        </div>

        {{-- Graphique synthétique --}}
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-700">
                    <i class="fas fa-chart-bar mr-2 text-gray-600" aria-hidden="true"></i>
                    Vue synthétique
                </h3>
                <div class="text-sm text-gray-500">
                    Répartition globale
                </div>
            </div>
            <div class="w-full max-w-3xl mx-auto">
                <canvas id="dashboardChart" class="w-full" style="max-height: 320px;"></canvas>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stats = {!! json_encode($stats) !!};
        const canvas = document.getElementById('dashboardChart');

        if (!canvas) {
            console.error('❌ Canvas introuvable');
            return;
        }

        const ctx = canvas.getContext('2d');
        if (!ctx) {
            console.error('❌ Impossible d’obtenir le contexte 2D');
            return;
        }

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Agences', 'Zones', 'Postes'],
                datasets: [{
                    label: 'Nombre total',
                    data: [stats.agences, stats.zones, stats.postes],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(99, 102, 241, 0.8)',
                        'rgba(16, 185, 129, 0.8)'
                    ],
                    borderColor: [
                        'rgb(59, 130, 246)',
                        'rgb(99, 102, 241)',
                        'rgb(16, 185, 129)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Valeur numérique'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Catégories'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    });
</script>
@endsection