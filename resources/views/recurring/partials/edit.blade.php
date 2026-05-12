<form action="{{ route('recurring.update', $recurring->recurring_id) }}" method="POST">
    @csrf
    @method('PUT')
    <h3 class="text-xl font-bold text-gray-800">Ismétlődő tranzakció szerkesztése</h3>
    <hr class="my-4 border-gray-200">

    <div class="space-y-4">
        <!-- Name -->
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Megnevezés</label>
            <input type="text" name="recurring_name" value="{{ $recurring->recurring_name }}" 
                class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1" required >
        </div>

        <div class="grid grid-cols-2 gap-4">
            <!-- Amount -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Összeg</label>
                <input type="number" step="0.01" name="recurring_amount" value="{{ $recurring->recurring_amount }}" 
                    class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1" required>
            </div>

            <!-- Currency -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Pénznem</label>
                <select name="currency_id" class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
                    @foreach($currencies as $currency)
                        <option value="{{ $currency->currency_id }}" {{ $recurring->currency_id == $currency->currency_id ? 'selected' : '' }}>
                            {{ $currency->currency_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <!-- Category and subcategory -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Kategória</label>
                <select name="category_id" id="modal_category_select" 
                    class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1" required >
                    @foreach($categories as $cat)
                        <option value="{{ $cat->category_id }}" {{ $recurring->category_id == $cat->category_id ? 'selected' : '' }}>
                            {{ $cat->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>    
                <label class="block text-sm font-bold text-gray-700 mb-1">Alketegória</label>
                <select name="subcategory_id" id="modal_subcategory_select" 
                    class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1" required>
                    @foreach($subcategories as $subcat)
                        <option value="{{ $subcat->subcategory_id }}" {{ $recurring->subcategory_id == $subcat->subcategory_id ? 'selected' : '' }}>
                            {{ $subcat->subcategory_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Account -->
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Számla</label>
            <select name="account_id" class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
                @foreach($accounts as $account)
                    <option value="{{ $account->account_id }}" {{ $recurring->account_id == $account->account_id ? 'selected' : '' }}>
                        {{ $account->account_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Start date -->
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Következő esedékesség</label>
            <input type="date" name="next_execution_date" value="{{ $recurring->next_execution_date->format('Y-m-d') }}" 
                class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1" required>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <!-- Intervall -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Intervallum</label>
                <input type="number" name="frequency_intervall" value="{{ $recurring->frequency_intervall }}" min="1" 
                    class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1" required>
            </div>

            <!-- Frequency -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Gyakoriság típusa</label>
                <select name="frequency_type" class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
                    <option value="daily" {{ $recurring->frequency_type == 'daily' ? 'selected' : '' }}>Napi</option>
                    <option value="weekly" {{ $recurring->frequency_type == 'weekly' ? 'selected' : '' }}>Heti</option>
                    <option value="monthly" {{ $recurring->frequency_type == 'monthly' ? 'selected' : '' }}>Havi</option>
                    <option value="yearly" {{ $recurring->frequency_type == 'yearly' ? 'selected' : '' }}>Éves</option>
                </select>
            </div>

        </div>

        <div class="flex items-center gap-6 pt-2">
            <!-- Prediction -->
            <label class="inline-flex items-center text-sm text-gray-900 cursor-pointer">
                <input type="checkbox" name="recurring_is_prediction" value="1" {{ $recurring->recurring_is_prediction ? 'checked' : '' }}
                    class="rounded border-gray-300 !text-green-600 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500" style="accent-color: #15803d;">
                <span class="ml-2">Várható</span>
            </label>

            <!-- Active -->
            <label class="inline-flex items-center text-sm text-gray-900 cursor-pointer">
                <input type="checkbox" name="recurring_is_active" value="1" {{ $recurring->recurring_is_active ? 'checked' : '' }}
                    class="rounded border-gray-300 !text-green-600 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500" style="accent-color: #15803d;">
                <span class="ml-2">Aktív</span>
            </label>
        </div>
    </div>

    <!-- Buttons -->
    <div class="mt-8 flex justify-end gap-3">
        <button type="button" onclick="closeEditModal()" 
            class="px-5 py-2.5 bg-gray-100 text-gray-600 text-sm font-bold rounded-sm hover:bg-gray-200 transition">
            Mégse
        </button>
        <button type="submit" 
            class="px-5 py-2.5 bg-green-700 hover:bg-green-800 text-white text-sm font-bold rounded-sm shadow-md transition active:scale-95">
            Mentés
        </button>
    </div>
</form>