@props(['pendingTransactions'])

<div class="mt-8 bg-white rounded-sm border border-amber-200 shadow-sm overflow-hidden">
    <!-- Header -->
    <div class="bg-amber-50 px-4 py-3 border-b border-amber-100 flex justify-between items-center">
        <h3 class="text-sm font-bold text-amber-800 uppercase tracking-wider">
            Jóváhagyásra váró tételek ({{ $pendingTransactions->count() }})
        </h3>
    </div>

    <!-- list -->
    <div class="divide-y divide-gray-100">
        @forelse($pendingTransactions as $pending)
            <div class="p-4 hover:bg-gray-50 transition-colors flex flex-wrap md:flex-nowrap items-center justify-between gap-4">
                
                <!-- Info -->
                <div class="flex-1 min-w-[200px]">
                    <div class="flex items-center gap-3 mb-1">
                        <span class="text-xs font-bold text-gray-400">{{ date('Y. m. d.', strtotime($pending->transaction_date_completed)) }}</span>
                        <span class="text-sm text-gray-800">{{ $pending->transaction_description ?? 'Leírás nélkül' }}</span>
                    </div>
                    <div class="text-sm font-bold text-gray-900">
                        {{ $pending->category->category_name}} / {{ $pending->subcategory->subcategory_name}}
                    </div>
                    <div class="text-lg font-bold text-gray-900">
                        {{ number_format($pending->transaction_amount, 0, ',', ' ') }} 
                        <span class="text-sm text-gray-500 font-medium">{{ $pending->currency->currency_sign }}</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-2">
                    <!-- Approve -->
                    <form action="{{ route('transactions.approve', $pending->transaction_id) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" title="Jóváhagyás"
                            class="w-10 h-10 flex items-center justify-center bg-green-100 text-green-700 rounded-sm hover:bg-green-700 hover:text-white transition active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </form>

                    <!-- Edit -->
                    <button type="button" onclick="editTransaction({{ $pending->transaction_id }})" title="Szerkesztés"
                        class="w-10 h-10 flex items-center justify-center bg-blue-50 text-blue-600 rounded-sm hover:bg-blue-600 hover:text-white transition active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>

                    <!-- Decline -->
                    <form action="{{ route('transactions.destroy', $pending->transaction_id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Törlöd ezt a javaslatot?')" title="Elvetés"
                            class="w-10 h-10 flex items-center justify-center bg-red-50 text-red-600 rounded-sm hover:bg-red-700 hover:text-white transition active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-8 text-center text-gray-500 italic text-sm">
                Nincs jóváhagyásra váró tétel.
            </div>
        @endforelse
    </div>
</div>

<!-- Modal Shell -->
<div id="transactionModal" class="modal-overlay" style="display: none;">
    <div class="modal-content !max-w-lg">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <div id="modal-body" class="p-2">
            
        </div>
    </div>
</div>