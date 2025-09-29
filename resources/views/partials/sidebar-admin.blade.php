<aside class="w-64 bg-white shadow-md">
    <div class="p-6 border-b">
        <h1 class="text-xl font-bold text-purple-600">CEET Administrateur</h1>
    </div>
    <nav class="p-6 space-y-4 text-gray-700">
        <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Tableau de bord</a>
        <a href="{{ route('users.index') }}"><i class="fas fa-users-cog"></i> Utilisateurs</a>
        <a href="{{ route('roles.index') }}"><i class="fas fa-user-shield"></i> Rôles & Permissions</a>
        <a href="{{ route('zones.index') }}"><i class="fas fa-map-marked-alt"></i> Zones</a>
        <a href="{{ route('postes.index') }}"><i class="fas fa-bolt"></i> Postes</a>
    </nav>
</aside>