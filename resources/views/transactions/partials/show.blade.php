<h4>Tranzakció részletei</h4>
<hr>
<p><strong>Dátum:</strong> {{ $transaction->transaction_date_completed }}</p>
<p><strong>Összeg:</strong> {{ number_format($transaction->transaction_amount, 0, ',', ' ') }} {{ $transaction->currency->currency_sign }}</p>
<p><strong>Kategória:</strong> {{ $transaction->category->category_name }}</p>
<p><strong>Leírás:</strong> {{ $transaction->transaction_description ?? '-' }}</p>

<div style="margin-top: 20px; display: flex; gap: 10px;">
    <a href="{{ route('transactions.edit', $transaction->transaction_id) }}" class="btn-edit">Szerkesztés</a>
    
    <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-delete" onclick="return confirm('Biztosan törölni akarod?')">Törlés</button>
    </form>
</div>