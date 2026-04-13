window.createTransaction = function() {
    const modal = document.getElementById('transactionModal');
    const body = document.getElementById('modal-body');

    modal.style.display = 'block';
    body.innerHTML = '<p>Betöltés...</p>';

    fetch(`/transactions/create`)
        .then(response => response.text())
        .then(html => {
            body.innerHTML = html;
        });
}