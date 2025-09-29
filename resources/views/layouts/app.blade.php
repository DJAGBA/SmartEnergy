<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        {{-- Navbar Breeze — FIXÉE EN HAUT --}}
        <div class="fixed top-0 left-0 right-0 z-50">
            @include('layouts.navigation')
        </div>

        {{-- Layout principal : sidebar + contenu — décalé sous la navbar --}}
        <div class="flex pt-[64px] min-h-screen">

            {{-- Sidebar dynamique selon le rôle — FIXÉE À GAUCHE --}}
            @auth
                <aside class="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:top-[64px] lg:bottom-0 lg:z-30 bg-white shadow-xl border-r border-gray-200">
                    <div class="flex-1 flex flex-col">
                        @role('admin')
                            @include('partials.sidebar-admin')
                        @endrole

                        @role('gestionnaire')
                            @include('partials.sidebar-gestionnaire')
                        @endrole

                        @role('technicien')
                            @include('partials.sidebar-technicien')
                        @endrole
                    </div>
                </aside>
            @endauth

            {{-- Contenu principal — décalé à droite si sidebar visible --}}
            <div class="flex-1 lg:ml-64">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @hasSection('header')
                        <header class="mb-6">
                            @yield('header')
                        </header>
                    @endif

                    <main>
                        @yield('content')
                    </main>
                </div>
            </div>

        </div>
    </div>
    @yield('scripts')
</body>
</html>