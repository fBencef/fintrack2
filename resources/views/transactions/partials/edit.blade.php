<!-- resources/views/transactions/partials/edit.blade.php -->
<form action="{{ route('transactions.update', $transaction->transaction_id) }}" method="POST" class="p-1">
    @csrf
    @method('PUT')

    <h3 class="text-xl font-bold text-gray-800">Tranzakció szerkesztése</h3>
    <hr class="my-4 border-gray-200">

    <div class="space-y-4">
        <!-- ID and Date -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">ID:</label>
                <input type="number" name="transaction_id" value="{{ $transaction->transaction_id }}" readonly
                    class="w-full rounded-sm border-gray-200 bg-gray-100 text-gray-500 cursor-not-allowed text-sm p-1 outline-none shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Dátum:</label>
                <input type="date" name="transaction_date_completed" 
                    value="{{ date('Y-m-d', strtotime($transaction->transaction_date_completed)) }}" required
                    class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
            </div>
        </div>

        <!-- Amount and Account -->
        <div class="mb-4">
            <label class="block text-sm font-bold text-gray-700 mb-2">Tranzakció típusa</label>
            <div class="flex gap-2">
                <label class="flex-1 cursor-pointer">
                    <input type="radio" name="type_toggle" value="expense" class="hidden peer" {{ $transaction->transaction_amount < 0 ? 'checked' : '' }}>
                    <div class="text-center p-2 border border-gray-300 rounded-sm peer-checked:bg-red-50 peer-checked:border-red-600 peer-checked:text-red-700 transition font-bold text-sm">
                        Kiadás (-)
                    </div>
                </label>
                <label class="flex-1 cursor-pointer">
                    <input type="radio" name="type_toggle" value="income" class="hidden peer" {{ $transaction->transaction_amount > 0 ? 'checked' : '' }}>
                    <div class="text-center p-2 border border-gray-300 rounded-sm peer-checked:bg-emerald-50 peer-checked:border-emerald-600 peer-checked:text-emerald-700 transition font-bold text-sm">
                        Bevétel (+)
                    </div>
                </label>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Összeg:</label>
                <input type="number" step="0.01" name="transaction_amount" value="{{ abs($transaction->transaction_amount) }}" required
                    class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Számla:</label>
                <select name="account_id" id="modal_account_select"
                    class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
                    @foreach($accounts as $account)
                        <option value="{{ $account->account_id }}" {{ $transaction->account_id == $account->account_id ? 'selected' : '' }}>
                            {{ $account->account_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Category and Subcategory -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Kategória:</label>
                <select name="category_id" id="modal_category_select"
                    class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->category_id }}" {{ $transaction->category_id == $cat->category_id ? 'selected' : '' }}>
                            {{ $cat->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Alkategória:</label>
                <select name="subcategory_id" id="modal_subcategory_select"
                    class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
                    <option value="">-- nincs alkategória --</option>
                    @foreach($subcategories as $subcat)
                        <option value="{{ $subcat->subcategory_id }}" {{ $transaction->subcategory_id == $subcat->subcategory_id ? 'selected' : '' }}>
                            {{ $subcat->subcategory_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Currency -->
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Pénznem:</label>
            <select name="currency_id" id="modal_currency_select"
                class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
                @foreach($currencies as $currency)
                    <option value="{{ $currency->currency_id }}" {{ $transaction->currency_id == $currency->currency_id ? 'selected' : '' }}>
                        {{ $currency->currency_name }} ({{ $currency->currency_sign }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Split -->
        <div class="bg-gray-50 p-3 rounded-sm border border-gray-200">
            <div class="flex items-center mb-3">
                <input type="checkbox" name="is_split" id="edit_is_split" value="1" {{ $transaction->is_split ? 'checked' : '' }}
                    class="rounded border-gray-300 !text-green-600 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500" style="accent-color: #15803d;">
                <label for="edit_is_split" class="text-sm font-bold text-gray-700 cursor-pointer pl-1">Megosztott költség</label>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Saját rész összege:</label>
                <input type="number" step="0.01" name="transaction_split_amount" value="{{ $transaction->transaction_split_amount }}"
                    class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
            </div>
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Leírás:</label>
            <textarea name="transaction_description" rows="2"
                class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">{{ $transaction->transaction_description }}</textarea>
        </div>
    </div>

    <!-- Status field to handle approvals differnt -->
    <input type="hidden" name="transaction_status" value="{{ $transaction->transaction_status }}">

    <!-- Buttons -->
    <div class="mt-8 flex justify-end gap-3">
        @if($transaction->transaction_status === 'pending')
            <button type="button" onclick="closeModal()" 
                class="px-5 py-2.5 bg-gray-100 text-gray-600 text-sm font-bold rounded-sm hover:bg-gray-200 transition">
                Mégse
            </button>
        @else
            <button type="button" onclick="showTransactionDetails({{ $transaction->transaction_id }})" 
                class="px-5 py-2.5 bg-gray-100 text-gray-600 text-sm font-bold rounded-sm hover:bg-gray-200 transition">
                Mégse
            </button>
        @endif

        <button type="submit" 
            class="px-8 py-2.5 bg-green-700 hover:bg-green-800 text-white text-sm font-bold rounded-sm shadow-md transition active:scale-95">
            Mentés
        </button>
    </div>
</form>