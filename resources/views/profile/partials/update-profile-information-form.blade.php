<section>
    <header>
        <h2 class="text-xl font-bold text-gray-800">
            {{ __('Profil adatok') }}
        </h2>
        <hr class="my-4 border-gray-200">
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Felhasználónév és e-mail cím frissítése.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-4">
        @csrf
        @method('patch')

        <!-- Name Field -->
        <div>
            <x-input-label for="name" :value="__('Név')" class="block text-sm font-bold text-gray-700 mb-1" />
            <x-text-input 
                id="name" 
                name="name" 
                type="text" 
                class="mt-1 block w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1" 
                :value="old('name', $user->name)" 
                required 
                autofocus 
                autocomplete="name" 
            />
            <x-input-error class="mt-2 text-xs font-bold text-red-600" :messages="$errors->get('name')" />
        </div>

        <!-- Email Field -->
        <div>
            <x-input-label for="email" :value="__('Email cím')" class="block text-sm font-bold text-gray-700 mb-1" />
            <x-text-input 
                id="email" 
                name="email" 
                type="email" 
                class="mt-1 block w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1" 
                :value="old('email', $user->email)" 
                required 
                autocomplete="username" 
            />
            <x-input-error class="mt-2 text-xs font-bold text-red-600" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-3 bg-amber-50 border border-amber-100 rounded-sm">
                    <p class="text-sm text-amber-800">
                        {{ __('Az Ön e-mail címe nincs megerősítve.') }}

                        <button form="send-verification" class="block mt-1 underline text-xs font-bold text-amber-900 hover:text-green-700 transition">
                            {{ __('Kattintson ide a megerősítő e-mail újraküldéséhez.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-bold text-xs text-green-600 italic">
                            {{ __('Új megerősítő linket küldtünk az e-mail címére.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button class="px-8 py-2.5 bg-green-700 hover:bg-green-800 text-white text-sm font-bold rounded-sm shadow-md transition active:scale-95">
                {{ __('Mentés') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-bold text-green-600"
                >{{ __('Elmentve.') }}</p>
            @endif
        </div>
    </form>
</section>