<x-layout title="All Transactions">
    <h2>All Transactions ({{ $transactions->total() }})</h2>

    <table border="1" cellpadding="10" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>Date</th>
                <th>Description</th>
                <th>Category</th>
                <th>Account</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->transaction_date_completed }}</td>
                    <td>{{ $transaction->transaction_description ?? '-' }}</td>
                    <td>{{ $transaction->category->category_name }}</td>
                    <td>{{ $transaction->account->account_name }}</td>
                    <td style="font-weight: bold; color: {{ $transaction->category->category_direction == '-' ? 'red' : 'green' }}">
                        {{ number_format($transaction->transaction_amount, 2) }} 
                        {{ $transaction->currency->currency_sign }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $transactions->links() }}
    </div>
</x-layout>