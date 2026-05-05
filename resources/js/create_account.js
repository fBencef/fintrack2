window.openCreateAccountModal = function() {
    const modal = document.getElementById('accountModal');
    const body = document.getElementById('accountModalBody');
    
    modal.style.display = 'block';
    body.innerHTML = '<p class="p-5 text-center text-gray-500 text-sm">Betöltés...</p>';
    
    fetch('/accounts/create')
        .then(response => response.text())
        .then(html => {
            body.innerHTML = html;
        });
}

window.closeAccountModal = function() {
    document.getElementById('accountModal').style.display = 'none';
}

window.openEditAccountModal = function(accountId) {
    const modal = document.getElementById('editAccountModal');
    const body = document.getElementById('accountEditBody');

    modal.style.display = 'block';
    body.innerHTML = '<p class="p-5 text-center text-gray-500 text-sm">Betöltés...</p>';

    fetch(`/accounts/${accountId}/edit`)
        .then(response => response.text())
        .then(html => {
            body.innerHTML = html;
            
            const form = document.getElementById('editAccountForm');
            if (form) {
                form.action = `/settings/accounts/${accountId}`;
            }
        });
}

window.closeEditAccountModal = function() {
    document.getElementById('editAccountModal').style.display = 'none';
}