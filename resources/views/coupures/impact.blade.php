@extends('layouts.app')

@section('content')
<div class="container py-6">
    <h1 class="text-2xl font-bold text-black mb-6 flex items-center">
        <i class="fas fa-chart-line mr-2"></i> Analyse visuelle des coupures
    </h1>

    {{-- Fréquence des coupures --}}
    <div class="mb-10">
        <h3 class="text-lg font-semibold text-gray-700 mb-2 flex items-center">
            <i class="fas fa-bolt text-yellow-500 mr-2"></i> Fréquence des coupures par zone
        </h3>
        <div class="bg-white rounded shadow p-4 h-[300px]">
            <canvas id="frequenceChart"></canvas>
        </div>
    </div>

    {{-- Durée moyenne des coupures --}}
    <div class="mb-10">
        <h3 class="text-lg font-semibold text-gray-700 mb-2 flex items-center">
            <i class="fas fa-clock text-blue-500 mr-2"></i> Durée moyenne des coupures
        </h3>
        <div class="bg-white rounded shadow p-4 h-[300px]">
            <canvas id="dureeChart"></canvas>
        </div>
    </div>

    {{-- Retours clients --}}
    <div class="mt-10">
        <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
            <i class="fas fa-comments text-green-600 mr-2"></i> Retours des utilisateurs
        </h3>

        @php
        $retours = collect([
            (object)[ 'user' => (object)['name' => 'Koffi A.'], 'zone' => (object)['nom' => 'Zone Nord'], 'note' => 5,
                'message' => "Je suis très satisfait de la plateforme. Grâce aux alertes, je peux anticiper les coupures et m’organiser à l’avance.",
                'created_at' => now()->subHours(3),
            ],
            (object)[ 'user' => (object)['name' => 'Aminata B.'], 'zone' => (object)['nom' => 'Zone Sud'], 'note' => 4,
                'message' => "Avant, les coupures me surprenaient. Maintenant, je reçois une notification et je peux prévenir mes enfants à temps.",
                'created_at' => now()->subDays(1),
            ],
            (object)[ 'user' => (object)['name' => 'AHLO'], 'zone' => (object)['nom' => 'Zone Sud'], 'note' => 4,
                'message' => "Les alertes sont claires et arrivent à temps. Je peux prévenir mes enfants et éviter les mauvaises surprises.",
                'created_at' => now()->subDays(1),
            ],
            (object)[ 'user' => (object)['name' => 'ABALO'], 'zone' => (object)['nom' => 'Zone Est'], 'note' => 5,
                'message' => "Très satisfait du service. Avant je subissais les coupures sans prévenir, maintenant je suis toujours prêt.",
                'created_at' => now()->subDays(2),
            ],
            (object)[ 'user' => (object)['name' => 'Jean M.'], 'zone' => (object)['nom' => 'Zone Est'], 'note' => 5,
                'message' => "Très utile pour planifier mes activités. Je sais quand l’électricité sera coupée et je peux adapter mon planning.",
                'created_at' => now()->subDays(2),
            ],
            (object)[ 'user' => (object)['name' => 'Fatou D.'], 'zone' => (object)['nom' => 'Zone Ouest'], 'note' => 5,
                'message' => "Merci pour ce service. Je suis moins stressée car je sais à l’avance quand il y aura une coupure.",
                'created_at' => now()->subDays(3),
            ],
            (object)[ 'user' => (object)['name' => 'Kodjo T.'], 'zone' => (object)['nom' => 'Zone Centrale'], 'note' => 4,
                'message' => "La plateforme m’aide à mieux gérer mon commerce. Je peux prévenir mes clients et éviter les pertes.",
                'created_at' => now()->subDays(4),
            ],
        ]);
        @endphp

        <div class="bg-white rounded shadow p-4">
            @forelse($retours as $fb)
                <div class="border-b border-gray-200 py-4">
                    <div class="flex justify-between items-center mb-2">
                        <h5 class="font-semibold text-gray-800">
                            <i class="fas fa-user text-gray-500 mr-1"></i> {{ $fb->user->name ?? 'Utilisateur anonyme' }}
                            <span class="text-sm text-gray-500">— {{ $fb->zone->nom ?? 'Zone inconnue' }}</span>
                        </h5>
                        <span class="text-yellow-500 text-sm">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $fb->note ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                            @endfor
                        </span>
                    </div>
                    <p class="text-gray-700 italic">
                        <i class="fas fa-quote-left text-green-600 mr-1"></i> {{ $fb->message }}
                    </p>
                    <p class="text-end text-xs text-gray-500 mt-2">
                        <i class="fas fa-clock mr-1"></i> {{ $fb->created_at->format('d/m/Y à H:i') }}
                    </p>
                </div>
            @empty
                <p class="text-gray-500">Aucun retour client enregistré pour le moment.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const labels = {!! json_encode($labels) !!};
    const frequenceData = {!! json_encode($frequenceData) !!};
    const dureeData = {!! json_encode($dureeData) !!};

    if (Array.isArray(labels) && labels.length > 0 && Array.isArray(frequenceData) && Array.isArray(dureeData)) {
        const frequenceCtx = document.getElementById('frequenceChart')?.getContext('2d');
        const dureeCtx = document.getElementById('dureeChart')?.getContext('2d');

        if (frequenceCtx) {
            new Chart(frequenceCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Fréquence des coupures',
                        data: frequenceData,
                        backgroundColor: 'rgba(255, 159, 64, 0.6)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    animation: false,
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        if (dureeCtx) {
            new Chart(dureeCtx, {
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
                    animation: false,
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }
    } else {
        console.warn('Données graphiques manquantes ou invalides.');
    }
});
</script>
@endsection