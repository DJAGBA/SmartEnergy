<x-guest-layout>
    <!-- Logo CEET -->
    <div class="flex justify-center mb-4">
        <img src="{{ asset('images/ceet.png') }}" alt="Logo CEET" class="h-20 w-auto">
    </div>

    <!-- Icône de profil -->
    <div class="flex justify-center mb-6">
        <i class="fas fa-user-circle text-6xl text-indigo-600"></i>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Formulaire de connexion -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Submit -->
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3 inline-flex items-center gap-2">
                <i class="fas fa-sign-in-alt"></i>
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>