@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-app-layout title="All Transactions">
    <h2>Tranzakciók ({{ $transactions->total() }})</h2>

    <!--Filters (sidebar)-->
    <x-slot name="sidebar">
        <h3>Filters</h3>
        <hr>
        <form action="{{ route('transactions.all') }}" method="GET">
        
        <!--Searchbar-->
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 12px; font-weight: bold;">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <!--Category dropdown-->
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 12px; font-weight: bold;">Category</label>
            <select name="category_id" id="all_category_select" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                <option value="">Minden kategória</option>
                @foreach($categories as $category)
                    <option value="{{ $category->category_id }}" {{ request('category_id') == $category->category_id ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!--Subcategory dropdown-->
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 12px; font-weight: bold;">Subcategory</label>
            <select name="subcategory_id" id="all_subcategory_select" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                <option value="">Minden alkategória</option>
                @foreach($subcategories as $subcategory)
                    <option value="{{ $subcategory->subcategory_id }}" {{ request('subcategory_id') == $subcategory->subcategory_id ? 'selected' : '' }}>
                        {{ $subcategory->subcategory_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" style="width: 100%; background: #3498db; color: white; border: none; padding: 10px; border-radius: 4px; cursor: pointer;">
            Apply Filters
        </button>
        
        <div style="margin-top: 10px; text-align: center;">
            <a href="{{ route('transactions.all') }}" style="font-size: 12px; color: #666;">Clear All Filters</a>
        </div>
    </form>
    </x-slot>
    
    <!--Content-->
    <table border="1" cellpadding="10" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>#</th>
                <th>Összeg</th>
                <th>Kategória</th>
                <th>Alkategória</th>
                <th>Teljesítés</th>
                <th>Számla</th>
                <th>Megjegyzés</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->transaction_id }}</td>
                    <td style="font-weight: bold; color: {{ $transaction->category->category_direction == '-' ? 'red' : 'green' }}">
                        {{ number_format($transaction->transaction_amount, 2) }} 
                        {{ $transaction->currency->currency_sign }}
                    </td>
                    <td>{{ $transaction->category->category_name }}</td>
                    <td>{{ $transaction->subcategory?->subcategory_name ?? '-' }}</td>
                    <td>{{ $transaction->transaction_date_completed }}</td>
                    <td>{{ $transaction->account->account_name }}</td>
                    <td>{{ $transaction->transaction_description ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination-container">
        {{ $transactions->appends(request()->query())->links('vendor.pagination.tailwind') }}
    </div>
</x-app-layout>