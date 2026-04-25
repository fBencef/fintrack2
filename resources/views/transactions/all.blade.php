<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tranzakciók ({{ $transactions->total() }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div style="display: flex; gap: 30px; align-items: flex-start;">
                    
                    <aside style="flex: 0 0 250px; background: #f9f9f9; padding: 15px; border-radius: 8px;">
                        <h3 class="font-bold text-lg mb-2">Szűrők</h3>
                        <hr class="mb-4">
                        
                        <form action="{{ route('transactions.all') }}" method="GET">
                            <div style="margin-bottom: 15px;">
                                <label style="display: block; font-size: 12px; font-weight: bold;">Keresés</label>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Keresés..." style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label style="display: block; font-size: 12px; font-weight: bold;">Kategória</label>
                                <select name="category_id" id="all_category_select" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                    <option value="">Minden kategória</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->category_id }}" {{ request('category_id') == $category->category_id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label style="display: block; font-size: 12px; font-weight: bold;">Alkategória</label>
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
                    </aside>

                    <div style="flex: 1;">
                        <table border="1" cellpadding="10" style="border-collapse: collapse; width: 100%; border: 1px solid #eee;">
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

                        <div class="mt-6">
                            {{ $transactions->appends(request()->query())->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>

                </div> </div>
        </div>
    </div>
</x-app-layout>