window.openCreateRecurringModal = function() {
    const modal = document.getElementById('recurringModal');
    const body = document.getElementById('recurringModalBody');
    modal.style.display = 'block';
    
    fetch('/recurring/create')
        .then(response => response.text())
        .then(html => {
            body.innerHTML = html;
        });
}

window.closeRecurringModal = function() {
    document.getElementById('recurringModal').style.display = 'none';
}