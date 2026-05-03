@props(['transactions', 'title' => 'Legutóbbi tranzakciók'])

<x-dashboard-card :title="$title" id="recent-transactions">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-400 uppercase border-b border-gray-100">
                <tr>
                    <th class="pb-2 font-medium">Dátum</th>
                    <th class="pb-2 font-medium">Kategória</th>
                    <th class="pb-2 font-medium text-right">Összeg</th>
                    <th class="pb-2 text-right"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 text-gray-600">
                            {{ \Carbon\Carbon::parse($transaction->transaction_date_completed)->format('m. d.') }}
                        </td>
                        <td class="py-3">
                            <span class="block font-medium text-gray-800">{{ $transaction->category->category_name }}</span>
                            @if($transaction->subcategory)
                                <span class="text-xs text-gray-400">{{ $transaction->subcategory->subcategory_name }}</span>
                            @endif
                        </td>
                        <td class="py-3 text-right font-bold {{ $transaction->transaction_amount < 0 ? 'text-red-500' : 'text-green-500' }}">
                            {{ number_format($transaction->transaction_amount, 0, ',', ' ') }} {{ $transaction->currency->currency_sign }} 
                        </td>
                        <td class="py-3 text-right">
                            <button onclick="showTransactionDetails({{ $transaction->transaction_id }})" class="text-blue-600 hover:underline">
                                Részletek...
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-4 text-center text-gray-400 italic">Nincs rögzített tranzakció.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-dashboard-card>