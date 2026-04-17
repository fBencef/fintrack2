<form action="{{ route('transactions.store') }}" method="POST">
    @csrf
    <h4>Új tranzakció</h4>
    <hr>

    <label>Dátum:</label>
    <input type="date" name="transaction_date_completed" value="{{ date('Y-m-d') }}" required>
    <br>

    <label>Összeg:</label>
    <input type="number" step="0.01" name="transaction_amount" required>
    <br>

    <label>Kategória:</label>
    <select name="category_id" id="modal_category_select" required>
        <option value="">-- Válassz kategóriát --</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->category_id }}">{{ $cat->category_name }}</option>
        @endforeach
    </select>

    <select name="subcategory_id" id="modal_subcategory_select">
        <option value="">-- Nincs alkategória --</option>
    </select>
    <br>

    <label>Pénznem:</label>
    <select name="currency_id" id="modal_currency_select">
        @foreach($currencies as $currency)
            <option value="{{ $currency->currency_id }}">{{ $currency->currency_name }}</option>
        @endforeach
    </select>
    <br>

    <label>Számla:</label>
    <select name="account_id" id="modal_account_select">
        @foreach($accounts as $account)
            <option value="{{ $account->account_id }}">{{ $account->account_name }}</option>
        @endforeach
    </select>
    <br>

    <label>Megosztott:</label>
    <input type="checkbox" name="is_split" value="1">
    <br>

    <label>Saját rész:</label>
    <input type="number" step="0.01" name="transaction_split_amount">
    <br>

    <label>Leírás:</label>
    <textarea name="transaction_description" placeholder="Adj meg leírást..."></textarea>
    <br>

    <div style="margin-top: 20px;">
        <button type="submit" class="btn-save">Mentés</button>
        <button type="button" onclick="closeModal()">Mégse</button>
    </div>
</form>