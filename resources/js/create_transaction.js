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

window.setDateToday = function() {
    const input_field = document.getElementById('transaction_date_input');
    const today = new Date().toISOString().split('T')[0];

    input_field.value = today;
}

window.setDateTodayMinus1 = function() {
    const input_field = document.getElementById('transaction_date_input');
    const yesterday = new Date();

    yesterday.setDate(yesterday.getDate() - 1); // Subtract one day
    const formattedYesterday = yesterday.toISOString().split('T')[0];

    input_field.value = formattedYesterday;
}

window.setDateTodayMinus2 = function() {
    const input_field = document.getElementById('transaction_date_input');
    const yesterday_2 = new Date();

    yesterday_2.setDate(yesterday_2.getDate() - 2); // Subtract two days
    const formattedYesterday_2 = yesterday_2.toISOString().split('T')[0];

    input_field.value = formattedYesterday_2;
}

window.setInputDate = function(diffDays) {
    const input_field = document.getElementById('transaction_date_input');
    const today = new Date();

    today.setDate(today.getDate() + diffDays); // Subtract the number of days
    const formattedDate = today.toISOString().split('T')[0];

    input_field.value = formattedDate;
}