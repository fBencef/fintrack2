window.openCreateAccountModal = function() {
    document.getElementById('accountModal').style.display = 'block';
}

window.closeAccountModal = function() {
    document.getElementById('accountModal').style.display = 'none';
}

window.openEditAccountModal = function(account) {
    document.getElementById('edit_account_name').value = account.account_name;
    
    document.getElementById('editAccountForm').action = `/settings/accounts/${account.account_id}`;
    
    document.getElementById('editAccountModal').style.display = 'block';
}

window.closeEditAccountModal = function() {
    document.getElementById('editAccountModal').style.display = 'none';
}