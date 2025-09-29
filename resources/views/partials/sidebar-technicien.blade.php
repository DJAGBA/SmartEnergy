<aside class="w-64 bg-white shadow-md fixed top-[64px] bottom-0 z-30 overflow-y-auto">
    <div class="flex flex-col min-h-full">
        <!-- Titre -->
        <div class="p-6 border-b">
            <h1 class="text-xl font-bold text-black">CEET Technicien</h1>
        </div>

        <!-- Navigation principale -->
        <nav class="px-6 py-6 text-gray-800 text-sm font-medium space-y-4">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 py-2 {{ request()->routeIs('dashboard') ? 'text-indigo-600 font-semibold' : 'hover:text-indigo-600' }}">
                <i class="fas fa-home {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-indigo-500' }}"></i>
                <span>Tableau de bord</span>
            </a>

            <a href="{{ route('postes.index') }}"
               class="flex items-center gap-3 py-2 {{ request()->routeIs('postes.index') ? 'text-indigo-600 font-semibold' : 'hover:text-indigo-600' }}">
                <i class="fas fa-bolt {{ request()->routeIs('postes.index') ? 'text-indigo-600' : 'text-indigo-500' }}"></i>
                <span>Postes de transformation</span>
            </a>

            <a href=" {{ route('historique.index') }}"
               class="flex items-center gap-3 py-2 {{ request()->routeIs('historique.index') ? 'text-indigo-600 font-semibold' : 'hover:text-indigo-600' }}">
                <i class="fas fa-history {{ request()->routeIs('historique.index') ? 'text-indigo-600' : 'text-indigo-500' }}"></i>
                <span>Historique</span>
            </a>
        </nav>

        <!-- Paramètres fixé en bas mais visible grâce au scroll
        <div class="mt-auto border-t border-gray-200 px-6 py-4">
            <a href=" {{ route('parametres.index') }}"
               class="flex items-center gap-3 py-2 text-gray-800 text-sm font-medium {{ request()->routeIs('parametres.index') ? 'text-indigo-600 font-semibold' : 'hover:text-indigo-600' }}">
                <i class="fas fa-cog {{ request()->routeIs('parametres.index') ? 'text-indigo-600' : 'text-indigo-500' }}"></i>
                <span>Paramètres</span>
            </a>
        </div> -->
    </div>
</aside>