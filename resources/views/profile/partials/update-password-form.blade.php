<section>
    <header>
        <h2 class="text-xl font-bold text-gray-800">
            {{ __('Jelszó frissítése') }}
        </h2>
        <hr class="my-4 border-gray-200">
        <p class="mt-1 text-sm text-gray-600">
            {{ __('A biztonság érdekében használj hosszú, egyedi jelszót.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-4">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Jelenlegi jelszó')" class="block text-sm font-bold text-gray-700 mb-1" />
            <x-text-input 
                id="update_password_current_password" 
                name="current_password" 
                type="password" 
                class="mt-1 block w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1" 
                autocomplete="current-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-xs font-bold text-red-600" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Új jelszó')" class="block text-sm font-bold text-gray-700 mb-1" />
            <x-text-input 
                id="update_password_password" 
                name="password" 
                type="password" 
                class="mt-1 block w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1" 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-xs font-bold text-red-600" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Jelszó megerősítése')" class="block text-sm font-bold text-gray-700 mb-1" />
            <x-text-input 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                type="password" 
                class="mt-1 block w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1" 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-xs font-bold text-red-600" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button class="px-8 py-2.5 bg-green-700 hover:bg-green-800 text-white text-sm font-bold rounded-sm shadow-md transition active:scale-95">
                {{ __('Mentés') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
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