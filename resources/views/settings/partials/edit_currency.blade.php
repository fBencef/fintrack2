<form id="editCurrencyForm" method="POST" class="p-1">
    @csrf
    @method('PUT')
    
    <h3 class="text-xl font-bold text-gray-800">Pénznem szerkesztése</h3>
    <hr class="my-4 border-gray-200">

    <div class="space-y-4">
        <!-- Name -->
        <div>
            <label for="edit_currency_name" class="block text-sm font-bold text-gray-700 mb-1">Pénznem neve:</label>
            <input type="text" name="currency_name" id="edit_currency_name" 
                value="{{ $currency->currency_name }}" required
                class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <!-- Abbreviation -->
            <div>
                <label for="edit_currency_abbreviation" class="block text-sm font-bold text-gray-700 mb-1">Rövidítés:</label>
                <input type="text" name="currency_abbreviation" id="edit_currency_abbreviation" 
                    value="{{ $currency->currency_abbreviation }}" required
                    class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
            </div>
            <!-- Sign -->
            <div>
                <label for="edit_currency_sign" class="block text-sm font-bold text-gray-700 mb-1">Jel:</label>
                <input type="text" name="currency_sign" id="edit_currency_sign" 
                    value="{{ $currency->currency_sign }}" required
                    class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
            </div>
        </div>

        <!-- Default -->
        <div class="pt-2">
            <label class="inline-flex items-center cursor-pointer group">
                <input type="checkbox" name="is_default_currency" id="edit_is_default_currency" value="1" 
                    {{ $currency->is_default_currency ? 'checked' : '' }}
                    class="rounded border-gray-300 !text-green-600 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500" style="accent-color: #15803d;">
                <span class="ml-2 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">Legyen ez az alapértelmezett</span>
            </label>
        </div>
    </div>

    <!-- Buttons -->
    <div class="mt-8 flex justify-end gap-3">
        <button type="button" onclick="window.closeEditCurrencyModal()" 
            class="px-5 py-2.5 bg-gray-100 text-gray-600 text-sm font-bold rounded-sm hover:bg-gray-200 transition">
            Mégse
        </button>
        <button type="submit" 
            class="px-8 py-2.5 bg-green-700 hover:bg-green-800 text-white text-sm font-bold rounded-sm shadow-md transition active:scale-95">
            Frissítés
        </button>
    </div>
</form>