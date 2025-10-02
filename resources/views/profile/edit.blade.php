@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-black leading-tight">
        {{ __('Profile') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Formulaire de mise à jour du profil --}}
        <div class="p-6 bg-yellow-50 shadow sm:rounded-lg">
            <h3 class="text-lg font-semibold text-black mb-4">Modifier les informations du profil</h3>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-black">Nom</label>
                    <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}"
                           class="mt-1 block w-full border-yellow-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring-yellow-500 text-black">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-black">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}"
                           class="mt-1 block w-full border-yellow-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring-yellow-500 text-black">
                </div>

                <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 font-semibold">
                    Mettre à jour
                </button>
            </form>
        </div>

        {{-- Formulaire de changement de mot de passe --}}
        <div class="p-6 bg-yellow-50 shadow sm:rounded-lg">
            <h3 class="text-lg font-semibold text-black mb-4">Changer le mot de passe</h3>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="current_password" class="block text-sm font-medium text-black">Mot de passe actuel</label>
                    <input type="password" name="current_password" id="current_password"
                           class="mt-1 block w-full border-yellow-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring-yellow-500 text-black">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-black">Nouveau mot de passe</label>
                    <input type="password" name="password" id="password"
                           class="mt-1 block w-full border-yellow-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring-yellow-500 text-black">
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-black">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="mt-1 block w-full border-yellow-300 rounded-md shadow-sm focus:border-yellow-500 focus:ring-yellow-500 text-black">
                </div>

                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-semibold">
                    Mettre à jour le mot de passe
                </button>
            </form>
        </div>

    </div>
</div>
@endsection