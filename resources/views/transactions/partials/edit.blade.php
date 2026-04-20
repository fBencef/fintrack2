<form action="{{ route('transactions.update', $transaction->transaction_id) }}" method="POST">
    @csrf
    @method('PUT')

    <h4>Szerkesztés</h4>
    <hr>

    <label>ID:</label>
    <input type="number" step="1" name="transaction_id" value="{{ $transaction->transaction_id }}" readonly>
    <br>

    <label>Dátum:</label>
    <input type="date" name="transaction_date_completed" value="{{ date('Y-m-d', strtotime($transaction->transaction_date_completed)) }}" required>
    <br>

    <label>Összeg:</label>
    <input type="number" step="0.01" name="transaction_amount" value="{{ $transaction->transaction_amount }}" required>
    <br>

    <label>Kategória:</label>
    <select name="category_id" id="modal_category_select">
        @foreach($categories as $cat)
            <option value="{{ $cat->category_id }}" {{ $transaction->category_id == $cat->category_id ? 'selected' : '' }}>
                {{ $cat->category_name }}
            </option>
        @endforeach
    </select>
    <select name="subcategory_id" id="modal_subcategory_select">
        <option value="">-- nincs alkategória --</option>
        @foreach($subcategories as $subcat)
            <option value="{{ $subcat->subcategory_id }}" {{ $transaction->subcategory_id == $subcat->subcategory_id ? 'selected' : '' }}>
                {{ $subcat->subcategory_name }}
            </option>
        @endforeach
    </select>
    <br>

    <label>Pénznem:</label>
    <select name="currency_id" id="modal_currency_select">
        @foreach($currencies as $currency)
            <option value="{{ $currency->currency_id }}" {{ $transaction->currency_id == $currency->currency_id ? 'selected' : '' }}>
                {{ $currency->currency_name }}
            </option>
        @endforeach
    </select>
    <br>

    <label>Számla:</label>
    <select name="account_id" id="modal_account_select">
        @foreach($accounts as $account)
            <option value="{{ $account->account_id }}" {{ $transaction->account_id == $account->account_id ? 'selected' : '' }}>
                {{ $account->account_name }}
            </option>
        @endforeach
    </select>
    <br>

    <label>Megosztott:</label>
    <input type="checkbox" name="is_split" value="1" {{ $transaction->is_split ? 'checked' : '' }}>
    <br>

    <label>Saját rész:</label>
    <input type="number" step="0.01" name="transaction_split_amount" value="{{ $transaction->transaction_split_amount }}">
    <br>

    <label>Leírás:</label>
    <textarea name="transaction_description">{{ $transaction->transaction_description }}</textarea>
    <br>

    <div style="margin-top: 15px;">
        <button type="submit" class="btn-save">Mentés</button>
        @if($transaction->transaction_status === 'pending')
            <button type="button" onclick="closeModal()">Mégse</button>
        @else
            <button type="button" onclick="showTransactionDetails({{ $transaction->transaction_id }})">Mégse</button>
        @endif
    </div>

    <!-- This is for the edit script to know wether it is a pending or an existing transaction-->
    <input type="hidden" name="transaction_status" value="{{ $transaction->transaction_status }}">
</form>