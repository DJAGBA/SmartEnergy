<aside class="w-64 bg-yellow-50 shadow-md fixed top-[64px] bottom-0 z-30 overflow-y-auto">
    <div class="flex flex-col min-h-full">

        <!-- Titre -->
        <div class="p-6 border-b border-yellow-200 bg-yellow-100">
            <h1 class="text-xl font-bold text-black">CEET Administrateur</h1>
        </div>

        <!-- Navigation principale -->
        <nav class="flex-1 px-6 py-6 space-y-4 text-sm font-medium text-black">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 py-2 {{ request()->routeIs('dashboard') ? 'text-red-600 font-semibold' : 'hover:text-yellow-600' }}">
                <i class="fas fa-home text-lg {{ request()->routeIs('dashboard') ? 'text-red-600' : 'text-yellow-600' }}"></i>
                <span>Tableau de bord</span>
            </a>

            <a href="{{ route('users.index') }}"
               class="flex items-center gap-3 py-2 {{ request()->routeIs('users.index') ? 'text-red-600 font-semibold' : 'hover:text-yellow-600' }}">
                <i class="fas fa-users-cog text-lg {{ request()->routeIs('users.index') ? 'text-red-600' : 'text-yellow-600' }}"></i>
                <span>Utilisateurs</span>
            </a>

            <a href="{{ route('roles.index') }}"
               class="flex items-center gap-3 py-2 {{ request()->routeIs('roles.index') ? 'text-red-600 font-semibold' : 'hover:text-yellow-600' }}">
                <i class="fas fa-user-shield text-lg {{ request()->routeIs('roles.index') ? 'text-red-600' : 'text-yellow-600' }}"></i>
                <span>Rôles & Permissions</span>
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