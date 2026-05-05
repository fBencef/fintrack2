<section class="space-y-6">
    <header>
        <h2 class="text-xl font-bold text-gray-800">
            {{ __('Fiók törlése') }}
        </h2>
        <hr class="my-4 border-gray-200">
        <p class="mt-1 text-sm text-gray-600 leading-relaxed">
            {{ __('A fiók törlésével minden adat és erőforrás véglegesen törlésre kerül.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-sm shadow-md transition active:scale-95"
    >
        {{ __('Fiók törlése') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-xl font-bold text-gray-800">
                {{ __('Biztosan törölni szeretnéd a fiókot?') }}
            </h2>
            <hr class="my-4 border-gray-200">

            <p class="mt-1 text-sm text-gray-600 leading-relaxed">
                {{ __('A törlés után minden adat véglegesen elvész. A törlési szándék megerősítéséhez add meg a jelszavad.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Jelszó') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1"
                    placeholder="{{ __('Jelszó') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <x-secondary-button 
                    x-on:click="$dispatch('close')"
                    class="px-5 py-2.5 bg-gray-100 text-gray-600 text-sm font-bold rounded-sm hover:bg-gray-200 transition"
                >
                    {{ __('Mégse') }}
                </x-secondary-button>

                <x-danger-button class="px-8 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-sm shadow-md transition active:scale-95 ms-3">
                    {{ __('Fiók végleges törlése') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>