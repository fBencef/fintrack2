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

window.editRecurring = function(id) {
    const modal = document.getElementById('editModal');
    const body = document.getElementById('recurringEditBody');
    
    modal.style.display = 'block';

    fetch(`/recurring/${id}/edit`)
        .then(response => response.text())
        .then(html => {
            body.innerHTML = html;
        })
}

window.closeEditModal = function() {
    document.getElementById('editModal').style.display = 'none';
}