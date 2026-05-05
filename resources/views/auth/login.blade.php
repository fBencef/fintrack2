<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-800">Üdv!</h2>
        <p class="text-sm text-gray-600 mt-1">Jelentkezz be a fiókodba.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email cím')" class="block text-sm font-bold text-gray-700 mb-1" />
            <x-text-input id="email" 
                class="block mt-1 w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-2" 
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-bold text-red-600" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Jelszó')" class="block text-sm font-bold text-gray-700 mb-1" />

            <x-text-input id="password" 
                class="block mt-1 w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-2"
                type="password"
                name="password"
                required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-bold text-red-600" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" 
                    class="rounded border-gray-300 !text-green-600 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500" style="accent-color: #15803d;" 
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">{{ __('Emlékezz rám') }}</span>
            </label>

            @if (Route::has('password.request'))
                <!--a class="text-sm text-green-700 hover:text-green-800 font-medium transition-colors" href="{{ route('password.request') }}">
                    {{ __('Elfelejtett jelszó?') }}
                </a-->
            @endif
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center px-8 py-3 bg-green-700 hover:bg-green-800 text-white text-sm font-bold rounded-sm shadow-md transition active:scale-95">
                {{ __('Bejelentkezés') }}
            </x-primary-button>
        </div>

        <div class="mt-8 border-t border-gray-100 pt-6 text-center">
            <p class="text-sm text-gray-600">
                {{ __('Nincs még fiókod?') }}
                <a href="{{ route('register') }}" class="text-green-700 hover:text-green-800 transition-colors ml-1">
                    {{ __('Regisztráció') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>