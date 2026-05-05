window.openCreateCurrencyModal = function() {
    const modal = document.getElementById('currencyModal');
    const body = document.getElementById('currencyModalBody');

    modal.style.display = 'block';
    body.innerHTML = '<p class="p-5 text-center text-gray-500 text-sm">Betöltés...</p>';

    fetch('/currencies/create')
        .then(response => response.text())
        .then(html => {
            body.innerHTML = html;
        })
}

window.closeCurrencyModal = function() {
    document.getElementById('currencyModal').style.display = 'none';
}

window.openEditCurrencyModal = function(currencyId) {
    const modal = document.getElementById('editCurrencyModal');
    const body = document.getElementById('currencyEditBody');

    modal.style.display = 'block';
    body.innerHTML = '<p class="p-5 text-center text-gray-500 text-sm">Betöltés...</p>';

    fetch(`/currencies/${currencyId}/edit`)
        .then(response => response.text())
        .then(html => {
            body.innerHTML = html;
            
            const form = document.getElementById('editCurrencyForm');
            if (form) {
                form.action = `settings/currencies/${currencyId}`;
            }
        });
}

window.closeEditCurrencyModal = function() {
    document.getElementById('editCurrencyModal').style.display = 'none';
}