window.openCreateCurrencyModal = function() {
    document.getElementById('currencyModal').style.display = 'block';
}

window.closeCurrencyModal = function() {
    document.getElementById('currencyModal').style.display = 'none';
}

window.openEditCurrencyModal = function(currency) {
    // Fill text boxes
    document.getElementById('edit_currency_name').value = currency.currency_name;
    document.getElementById('edit_currency_abbreviation').value = currency.currency_abbreviation;
    document.getElementById('edit_currency_sign').value = currency.currency_sign;
    
    // Fill checkbox
    document.getElementById('edit_is_default_currency').checked = currency.is_default_currency == 1;

    document.getElementById('editCurrencyForm').action = `/settings/currencies/${currency.currency_id}`;
    
    document.getElementById('editCurrencyModal').style.display = 'block';
}

window.closeEditCurrencyModal = function() {
    document.getElementById('editCurrencyModal').style.display = 'none';
}