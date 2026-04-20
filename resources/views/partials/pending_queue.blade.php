<div class="pending-container">
    <h3>Jóváhagyásra váró tételek ({{ $pendingTransactions->count() }})</h3>
    <table class="pivot-table">
        <thead>
            <tr>
                <th>Dátum</th>
                <th>Megnevezés</th>
                <th>Összeg</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pendingTransactions as $pending)
                <tr>
                    <td>{{ $pending->transaction_date_completed }}</td>
                    <td>{{ $pending->transaction_description }}</td>
                    <td>{{ number_format($pending->transaction_amount, 0, ',', ' ') }} {{ $pending->currency->currency_code }}</td>
                    <td>
                        <form action="{{ route('transactions.approve', $pending->transaction_id) }}" method="POST" style="display:inline;">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-approve">✔</button>
                        </form>

                        <button type="button" onclick="showTransactionDetails({{ $pending->transaction_id }})" class="btn-edit-pending">✎</button>

                        <form action="{{ route('transactions.destroy', $pending->transaction_id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-decline" onclick="return confirm('Törlöd ezt a javaslatot?')">✘</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">Nincs jóváhagyásra váró tétel.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>