<h4>Tranzakció részletei</h4>
<hr>
<p><strong>ID:</strong> {{ $transaction->transaction_id }}</p>
<p><strong>Dátum:</strong> {{ $transaction->transaction_date_completed }}</p>
<p><strong>Összeg:</strong> {{ number_format($transaction->transaction_amount, 0, ',', ' ') }} {{ $transaction->currency->currency_sign }}</p>
<p><strong>Kategória:</strong> {{ $transaction->category->category_name }} / {{ $transaction->subcategory?->subcategory_name ?? '-' }}</p>
<p><strong>Pénznem:</strong> {{ $transaction->currency->currency_name }}</p>
<p><strong>Számla:</strong> {{ $transaction->account->account_name }}</p>
<p><strong>Megosztott:</strong> {{ $transaction->is_split }}</p>
<p><strong>Saját rész:</strong> {{ $transaction->transaction_split_amount ?? '-' }}</p>
<p><strong>Leírás:</strong> {{ $transaction->transaction_description ?? '-' }}</p>

<div style="margin-top: 20px; display: flex; gap: 10px;">
    <a href="{{ route('transactions.edit', $transaction->transaction_id) }}" class="btn-edit">Szerkesztés</a>
    
    <form action="{{ route('transactions.destroy', $transaction->transaction_id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-delete" onclick="return confirm('Biztosan törölni akarod?')">Törlés</button>
    </form>
</div>