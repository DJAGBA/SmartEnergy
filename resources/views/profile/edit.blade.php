@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Profile') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Formulaire de mise à jour du profil --}}
        <div class="p-6 bg-white shadow sm:rounded-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Modifier les informations du profil</h3>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH') {{-- Laravel Breeze utilise PATCH pour cette route --}}

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Mettre à jour
                </button>
            </form>
        </div>

        {{-- Formulaire de changement de mot de passe --}}
        <div class="p-6 bg-white shadow sm:rounded-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Changer le mot de passe</h3>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT') {{-- Breeze utilise PUT ici, pas PATCH --}}

                <div class="mb-4">
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
                    <input type="password" name="current_password" id="current_password"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                    <input type="password" name="password" id="password"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Mettre à jour le mot de passe
                </button>
            </form>
        </div>

    </div>
</div>
@endsection