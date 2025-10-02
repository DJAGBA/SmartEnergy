<aside class="w-64 bg-yellow-50 shadow-md fixed top-[64px] bottom-0 z-30 overflow-y-auto">
    <div class="flex flex-col min-h-full">

        <!-- Titre -->
        <div class="p-6 border-b border-yellow-200 bg-yellow-100">
            <h1 class="text-xl font-bold text-black">CEET Gestionnaire</h1>
        </div>

        <!-- Navigation principale -->
        <nav class="px-6 py-6 text-black text-sm font-medium space-y-4">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 py-2 {{ request()->routeIs('dashboard') ? 'text-red-600 font-semibold' : 'hover:text-yellow-600' }}">
                <i class="fas fa-home {{ request()->routeIs('dashboard') ? 'text-red-600' : 'text-yellow-600' }}"></i>
                <span>Tableau de bord</span>
            </a>

            <a href="{{ route('coupures.index') }}"
               class="flex items-center gap-3 py-2 {{ request()->routeIs('coupures.planifier') ? 'text-red-600 font-semibold' : 'hover:text-yellow-600' }}">
                <i class="fas fa-calendar-plus {{ request()->routeIs('coupures.planifier') ? 'text-red-600' : 'text-yellow-600' }}"></i>
                <span>Planifier une coupure</span>
            </a>

            <a href="{{ route('coupures.historique') }}"
               class="flex items-center gap-3 py-2 {{ request()->routeIs('coupures.historique') ? 'text-red-600 font-semibold' : 'hover:text-yellow-600' }}">
                <i class="fas fa-history {{ request()->routeIs('coupures.historique') ? 'text-red-600' : 'text-yellow-600' }}"></i>
                <span>Historique des coupures</span>
            </a>

            <a href="{{ route('coupures.impact') }}"
               class="flex items-center gap-3 py-2 {{ request()->routeIs('coupures.impact') ? 'text-red-600 font-semibold' : 'hover:text-yellow-600' }}">
                <i class="fas fa-chart-line {{ request()->routeIs('coupures.impact') ? 'text-red-600' : 'text-yellow-600' }}"></i>
                <span>Rapport d’impact</span>
            </a>
        </nav>

        <!-- Déconnexion -->
        <div class="mt-auto border-t border-yellow-200 px-6 py-4 bg-yellow-100">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</aside>