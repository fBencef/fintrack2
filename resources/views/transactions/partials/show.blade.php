<!-- resources/views/transactions/partials/show.blade.php -->
<div class="p-1">
    <h3 class="text-xl font-bold text-gray-800">Tranzakció részletei</h3>
    <hr class="my-4 border-gray-200">

    <div class="space-y-4">
        <!-- Main grid -->
        <div class="grid grid-cols-2 gap-y-4 gap-x-6">
            <div>
                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Tranzakció ID</span>
                <span class="text-sm font-medium text-gray-900">#{{ $transaction->transaction_id }}</span>
            </div>
            <div>
                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Dátum</span>
                <span class="text-sm font-medium text-gray-900">{{ date('Y. m. d.', strtotime($transaction->transaction_date_completed)) }}</span>
            </div>

            <div>
                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Összeg</span>
                <span class="text-lg font-bold {{ $transaction->category->category_direction == '-' ? 'text-red-600' : 'text-green-600' }}">
                    {{ $transaction->transaction_amount > 0 ? '+' : '' }}{{ number_format($transaction->transaction_amount, 0, ',', ' ') }} {{ $transaction->currency->currency_sign }}
                </span>
            </div>
            <div>
                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Számla</span>
                <span class="text-sm font-medium text-gray-900">{{ $transaction->account->account_name }}</span>
            </div>

            <div class="col-span-2">
                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Kategória</span>
                <span class="text-sm font-medium text-gray-900">
                    {{ $transaction->category->category_name }} 
                    <span class="text-gray-400 mx-1">/</span> 
                    {{ $transaction->subcategory?->subcategory_name ?? 'Nincs alkategória' }}
                </span>
            </div>
        </div>

        <!-- Split box -->
        <div class="bg-gray-50 p-3 rounded-sm border border-gray-200 grid grid-cols-2 gap-4">
            <div>
                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Megosztott</span>
                @if($transaction->is_split)
                    <span class="inline-flex items-center px-2 py-0.5 text-xs font-bold rounded bg-emerald-100 text-emerald-700 border border-blue-200">
                        Igen
                    </span>
                @else
                    <span class="text-sm text-gray-500 italic">Nem</span>
                @endif
            </div>
            <div>
                <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Saját rész</span>
                <span class="text-sm font-bold text-gray-900">
                    {{ $transaction->transaction_split_amount ? number_format($transaction->transaction_split_amount, 0, ',', ' ') . ' ' . $transaction->currency->currency_sign : '-' }}
                </span>
            </div>
        </div>

        <!-- Description -->
        <div>
            <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Leírás</span>
            <p class="text-sm text-gray-700 bg-white border border-gray-100 p-2 rounded-sm italic">
                {{ $transaction->transaction_description ?? 'Nincs megjegyzés...' }}
            </p>
        </div>
    </div>

    <!-- Buttons -->
    <div class="mt-8 flex flex-wrap justify-end items-end gap-3">
        <form action="{{ route('transactions.destroy', $transaction->transaction_id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" 
                onclick="return confirm('Biztosan törölni akarod ezt a tranzakciót?')"
                class="px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-50 rounded-sm transition">
                Törlés
            </button>
        </form>

        <div class="flex gap-3">
            <button type="button" onclick="editTransaction({{ $transaction->transaction_id }})" 
                class="px-8 py-2.5 bg-green-700 hover:bg-green-800 text-white text-sm font-bold rounded-sm shadow-md transition active:scale-95">
                Szerkesztés
            </button>
        </div>
    </div>
</div>