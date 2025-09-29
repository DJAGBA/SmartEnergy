<nav x-data="{ open: false }" class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 shadow">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Notifications + User Menu -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-6">

               @role('technicien')
<div class="relative" x-data="{ openNotif: false }">
    <button @click="openNotif = !openNotif" class="text-gray-600 hover:text-gray-900 relative">
        <i class="fas fa-bell text-xl"></i>
        @isset($unreadCount)
            @if($unreadCount > 0)
                <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs rounded-full px-1">
                    {{ $unreadCount }}
                </span>
            @endif
        @endisset
    </button>

    <div x-show="openNotif" @click.away="openNotif = false"
         class="absolute right-0 mt-2 w-80 bg-white shadow-lg rounded-lg z-50 overflow-hidden">
        <div class="p-4 border-b font-semibold text-gray-700">Notifications</div>
        <ul class="max-h-64 overflow-y-auto">
            @foreach(auth()->user()->notifications()->latest()->take(5)->get() as $notification)
                <li class="px-4 py-2 hover:bg-gray-100 text-sm text-gray-700">
                    <a href="{{ route('postes.show', $notification->data['poste_id']) }}" class="block">
                        {{ $notification->data['message'] ?? 'Notification' }}
                        <span class="block text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="text-center p-2 border-t">
            <a href="{{ route('user-notifications.index') }}" class="text-indigo-600 text-sm hover:underline">Voir toutes les notifications</a>
        </div>
    </div>
</div>
@endrole

                {{-- Menu utilisateur --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-600 bg-white hover:text-gray-800 focus:outline-none transition ease-in-out duration-150 gap-3">
                            <i class="fas fa-user-circle text-xl text-gray-500"></i>

                            @role('admin')
                                <!-- <i class="fas fa-user-shield text-xl text-purple-600"></i> -->
                            @endrole
                            @role('gestionnaire')
                                <!-- <i class="fas fa-user-cog text-xl text-green-600"></i> -->
                            @endrole
                            @role('technicien')
                                <i class="fas fa-user-wrench text-xl text-indigo-600"></i>
                            @endrole
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="inline-flex items-center gap-3 text-gray-700 hover:text-indigo-600">
                            <i class="fas fa-user-circle text-lg"></i>
                            <span>{{ __('Profile') }}</span>
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                class="inline-flex items-center gap-3 text-red-600 hover:text-red-700"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt text-lg"></i>
                                <span>{{ __('Log Out') }}</span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': ! open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 flex items-center gap-3">
                <i class="fas fa-user-circle text-2xl text-gray-500"></i>

                @role('admin')
                    <i class="fas fa-user-shield text-2xl text-purple-600"></i>
                @endrole
                @role('gestionnaire')
                    <i class="fas fa-user-cog text-2xl text-green-600"></i>
                @endrole
                @role('technicien')
                    <i class="fas fa-user-wrench text-2xl text-indigo-600"></i>
                @endrole

                <div>
                   @auth
    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    @endauth
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="inline-flex items-center gap-3 text-gray-700 hover:text-indigo-600">
                    <i class="fas fa-user-circle text-lg"></i>
                    <span>{{ __('Profile') }}</span>
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        class="inline-flex items-center gap-3 text-red-600 hover:text-red-700"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt text-lg"></i>
                        <span>{{ __('Log Out') }}</span>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>