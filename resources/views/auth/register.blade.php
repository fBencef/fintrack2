<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-800">Fiók létrehozása</h2>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Username -->
        <div>
            <x-input-label for="name" :value="__('Felhasználónév')" class="block text-sm font-bold text-gray-700 mb-1" />
            <x-text-input id="name" 
                class="block mt-1 w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-2" 
                type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs font-bold text-red-600" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email cím')" class="block text-sm font-bold text-gray-700 mb-1" />
            <x-text-input id="email" 
                class="block mt-1 w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-2" 
                type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-bold text-red-600" />
        </div>

        <!-- Full Name (Given Name) -->
        <div class="mt-4">
            <x-input-label for="given_name" :value="__('Teljes név')" class="block text-sm font-bold text-gray-700 mb-1" />
            <x-text-input id="given_name" 
                class="block mt-1 w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-2" 
                type="text" name="given_name" :value="old('given_name')" required />
            <x-input-error :messages="$errors->get('given_name')" class="mt-2 text-xs font-bold text-red-600" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Jelszó')" class="block text-sm font-bold text-gray-700 mb-1" />
            <x-text-input id="password" 
                class="block mt-1 w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-2"
                type="password"
                name="password"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-bold text-red-600" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Jelszó megerősítése')" class="block text-sm font-bold text-gray-700 mb-1" />
            <x-text-input id="password_confirmation" 
                class="block mt-1 w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-2"
                type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs font-bold text-red-600" />
        </div>

        <div class="mt-8">
            <x-primary-button class="w-full justify-center px-8 py-3 bg-green-700 hover:bg-green-800 text-white text-sm font-bold rounded-sm shadow-md transition active:scale-95">
                {{ __('Regisztráció') }}
            </x-primary-button>
        </div>

        <!-- Back to Login -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                {{ __('Már regisztráltál? ') }}
                <a class="text-green-700 hover:text-green-800 transition-colors ml-1" href="{{ route('login') }}">
                    {{ __('Jelentkezz be!') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>