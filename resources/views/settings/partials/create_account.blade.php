<form action="{{ route('accounts.store') }}" method="POST" class="p-1">
    @csrf
    <h3 class="text-xl font-bold text-gray-800">Új számla</h3>
    <hr class="my-4 border-gray-200">

    <div class="space-y-4">
        <!-- Name -->
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Megnevezés:</label>
            <input type="text" name="account_name" placeholder="pl. Készpénz, Revolut" required
                class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
        </div>

        <!-- Currency -->
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Pénznem:</label>
            <select name="currency_id" required
                class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
                @foreach($currencies as $currency)
                    <option value="{{ $currency->currency_id }}">
                        {{ $currency->currency_name }} ({{ $currency->currency_sign }})
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Buttons -->
    <div class="mt-8 flex justify-end gap-3">
        <button type="button" onclick="window.closeAccountModal()" 
            class="px-5 py-2.5 bg-gray-100 text-gray-600 text-sm font-bold rounded-sm hover:bg-gray-200 transition">
            Mégse
        </button>
        <button type="submit" 
            class="px-8 py-2.5 bg-green-700 hover:bg-green-800 text-white text-sm font-bold rounded-sm shadow-md transition active:scale-95">
            Mentés
        </button>
    </div>
</form>