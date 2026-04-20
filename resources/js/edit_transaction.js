let isCurrentlyPending = false;

window.editTransaction = function(id, isPending = false) {
    isCurrentlyPending = isPending;
    
    const modal = document.getElementById('transactionModal');
    const body = document.getElementById('modal-body');

    modal.style.display = 'block';
    
    fetch(`/transactions/${id}/edit`)
        .then(response => response.text())
        .then(html => {
            body.innerHTML = html;
        });
}

window.closeModal = function() {
    document.getElementById('transactionModal').style.display = 'none';
}