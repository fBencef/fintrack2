window.editTransaction = function(id) {
    const body = document.getElementById('modal-body');
    
    fetch(`/transactions/${id}/edit`)
        .then(response => response.text())
        .then(html => {
            body.innerHTML = html;
        });
}