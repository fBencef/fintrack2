window.showTransactionDetails = function(id) {
    const modal = document.getElementById('transactionModal');
    const body = document.getElementById('modal-body');
    
    modal.style.display = 'block';
    
    // Fetch the data from thr Controller route
    fetch(`/transactions/${id}`)
        .then(response => response.text())
        .then(html => {
            body.innerHTML = html;
        });
}

window.closeModal = function() {
    document.getElementById('transactionModal').style.display = 'none';
}