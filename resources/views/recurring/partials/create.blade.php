<form action="{{ route('recurring.store') }}" method="POST">
    @csrf
    <h3>Új Ismétlődő tranzakció</h3>
    <hr>

    <label>Megnevezés:</label>
    <input type="text" name="recurring_name" placeholder="pl. Telekom Számla" required>
    <br>


    <label>Összeg:</label>
    <input type="number" step="0.01" name="recurring_amount" required>
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
            <option value="{{ $currency->currency_id }}">{{ $currency->currency_code }}</option>
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

    <label>Kezdő dátum:</label>
    <input type="date" name="recurring_start_date" value="{{ date('Y-m-d') }}" required>
    <br>


    <label>Gyakoriság típusa:</label>
    <select name="frequency_type">
        <option value="monthly">Havi</option>
        <option value="weekly">Heti</option>
        <option value="daily">Napi</option>
        <option value="yearly">Éves</option>
    </select>
    <br>

    <label>Intervallum (pl. minden 2. héten):</label>
    <input type="number" name="frequency_intervall" value="1" min="1" required>
    <br>

    <label>
        <input type="checkbox" name="recurring_is_prediction" value="1"> 
        Predikció
    </label>
    <br>

    <div style="margin-top: 20px;">
        <button type="submit" class="btn-save">Mentés</button>
    </div>
</form>