<form action="{{ route('recurring.store') }}" method="POST" class="p-1">
    @csrf
    <h3 class="text-xl font-bold text-gray-800">Új Ismétlődő tranzakció</h3>
    <hr class="my-4 border-gray-200">

    <div class="space-y-4">
        <!-- Name -->
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Megnevezés</label>
            <input type="text" name="recurring_name" placeholder="pl. Telekom Számla" required
                class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <!-- Amount -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Összeg</label>
                <input type="number" step="0.01" name="recurring_amount" required placeholder="500 Ft"
                    class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
            </div>

            <!-- Currency -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Pénznem</label>
                <select name="currency_id" id="modal_currency_select"
                    class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
                    @foreach($currencies as $currency)
                        <option value="{{ $currency->currency_id }}">{{ $currency->currency_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <!-- Category and subcategory -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Kategória</label>
                <select name="category_id" id="modal_category_select" required
                    class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
                    <option value="">-- Válassz kategóriát --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->category_id }}">{{ $cat->category_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Alkategória</label>
                <select name="subcategory_id" id="modal_subcategory_select"
                    class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
                    <option value="">-- Nincs alkategória --</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <!-- Account -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Számla</label>
                <select name="account_id" id="modal_account_select"
                    class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
                    @foreach($accounts as $account)
                        <option value="{{ $account->account_id }}">{{ $account->account_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Start date -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Kezdő esedékesség</label>
                <input type="date" name="recurring_start_date" value="{{ date('Y-m-d') }}" required
                    class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <!-- Intervall -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Intervallum</label>
                <input type="number" name="frequency_intervall" value="1" min="1" required
                    class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
            </div>
            
            <!-- Frequency -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Gyakoriság típusa</label>
                <select name="frequency_type"
                    class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
                    <option value="monthly">Havi</option>
                    <option value="weekly">Heti</option>
                    <option value="daily">Napi</option>
                    <option value="yearly">Éves</option>
                </select>
            </div>
        </div>



        <div class="flex items-center gap-6 pt-2">
            <!-- Prediction -->
            <label class="inline-flex items-center text-sm text-gray-900 cursor-pointer">
                <input type="checkbox" name="recurring_is_prediction" value="1"
                    class="rounded border-gray-300 !text-green-600 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500" style="accent-color: #15803d;">
                <span class="ml-2 font-bold text-gray-700">Várható</span>
            </label>

            <!-- Active -->
            <label class="inline-flex items-center text-sm text-gray-900 cursor-pointer">
                <input type="checkbox" name="recurring_is_active" value="1" checked
                    class="rounded border-gray-300 !text-green-600 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500" style="accent-color: #15803d;">
                <span class="ml-2 font-bold text-gray-700">Aktív</span>
            </label>
        </div>
    </div>

    <!-- Buttons -->
    <div class="mt-8 flex justify-end gap-3">
        <button type="button" onclick="closeRecurringModal()" 
            class="px-5 py-2.5 bg-gray-100 text-gray-600 text-sm font-bold rounded-sm hover:bg-gray-200 transition">
            Mégse
        </button>
        <button type="submit" 
            class="px-8 py-2.5 bg-green-700 hover:bg-green-800 text-white text-sm font-bold rounded-sm shadow-md transition active:scale-95">
            Mentés
        </button>
    </div>
</form>