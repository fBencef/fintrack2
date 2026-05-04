<!--DOCTYPE html-->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Minden tranzakció
        </h2>
    </x-slot>

    @if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div style="color: red; background: #ffeeee; padding: 10px; border: 1px solid red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg border border-gray-100">
                
                <!-- Layout container -->
                <div class="flex flex-col gap-8 md:flex-row items-start">
                    
                    <!-- Filters -->
                    <aside class="w-full md:w-64 flex-shrink-0 bg-gray-50 p-5 rounded-lg border border-gray-200">
                        <h3 class="mb-2 text-lg font-bold text-700 text-center">Szűrők</h3>
                        <hr class="mb-4 border-gray-200">
                        
                        <form action="{{ route('transactions.all') }}" method="GET" class="space-y-4">
                            <!-- Search -->
                            <div>
                                <label class="block mb-1 text-xs font-bold uppercase text-gray-500 tracking-wide">Keresés</label>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Keresés..." 
                                    class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-base p-1">
                            </div>

                            <!-- Category -->
                            <div>
                                <label class="block mb-1 text-xs font-bold uppercase text-gray-500 tracking-wide">Kategória</label>
                                <select name="category_id" id="all_category_select" 
                                    class="w-full rounded-sm border-gray-300 shadow-sm focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none text-base p-1">
                                    <option value="">Minden kategória</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->category_id }}" {{ request('category_id') == $category->category_id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Subcategory -->
                            <div>
                                <label class="block mb-1 text-xs font-bold uppercase text-gray-500 tracking-wide">Alkategória</label>
                                <select name="subcategory_id" id="all_subcategory_select" 
                                    class="w-full rounded-sm border-gray-300 shadow-sm focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none text-base p-1">
                                    <option value="">Minden alkategória</option>
                                    @foreach($subcategories as $subcategory)
                                        <option value="{{ $subcategory->subcategory_id }}" {{ request('subcategory_id') == $subcategory->subcategory_id ? 'selected' : '' }}>
                                            {{ $subcategory->subcategory_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" 
                                class="w-full py-2.5 px-4 bg-green-700 hover:bg-green-800 text-white font-bold rounded-sm shadow-sm transition-all active:scale-95">
                                Szűrők alkalmazása
                            </button>
                            
                            <div class="text-center">
                                <a href="{{ route('transactions.all') }}" class="text-sm text-gray-400 hover:text-green-700 transition-colors">
                                    Szűrők alaphelyzetbe
                                </a>
                            </div>
                        </form>
                    </aside>

                    <!-- Table -->
                    <div class="flex-1 w-full overflow-hidden">
                        <!-- Pagination top -->
                        <div class="pb-6">
                            {{ $transactions->appends(request()->query())->links() }}
                        </div>
                        <div class="overflow-x-auto border border-gray-100">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-center text-xs font-bold text-400 uppercase tracking-widest">#</th>
                                        <th class="px-4 py-3 text-center text-xs font-bold text-400 uppercase tracking-widest">Összeg</th>
                                        <th class="px-4 py-3 text-center text-xs font-bold text-400 uppercase tracking-widest">Kategória</th>
                                        <th class="px-4 py-3 text-center text-xs font-bold text-400 uppercase tracking-widest">Alkategória</th>
                                        <th class="px-4 py-3 text-center text-xs font-bold text-400 uppercase tracking-widest">Teljesítés</th>
                                        <th class="px-4 py-3 text-center text-xs font-bold text-400 uppercase tracking-widest">Számla</th>
                                        <th class="px-4 py-3 text-center text-xs font-bold text-400 uppercase tracking-widest">Megjegyzés</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($transactions as $transaction)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-4 text-sm text-gray-500">
                                                <button onclick="showTransactionDetails({{ $transaction->transaction_id }})" class="text-blue-600 hover:underline">
                                                    {{ $transaction->transaction_id }}
                                                </button>
                                            </td>
                                            <td class="px-4 py-4 text-sm font-bold whitespace-nowrap {{ $transaction->category->category_direction == '-' ? 'text-red-500' : 'text-emerald-600' }}">
                                                {{ $transaction->category->category_direction }}{{ number_format(abs($transaction->transaction_amount), 0, ',', ' ') }} 
                                                <span class="text-xs font-normal text-gray-700">{{ $transaction->currency->currency_sign }}</span>
                                            </td>
                                            <td class="px-4 py-4 text-sm text-gray-700 font-medium">
                                                {{ $transaction->category->category_name }}
                                            </td>
                                            <td class="px-4 py-4 text-sm text-gray-700">
                                                {{ $transaction->subcategory?->subcategory_name ?? '-' }}
                                            </td>
                                            <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap">
                                                {{ date('Y. m. d.', strtotime($transaction->transaction_date_completed)) }}
                                            </td>
                                            <td class="px-4 py-4 text-sm text-gray-700 text-sm">
                                                {{ $transaction->account->account_name }}
                                            </td>
                                            <td class="px-4 py-4 text-sm text-gray-500 max-w-[250px]">
                                                {{ $transaction->transaction_description ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination bottom -->
                        <div class="mt-6">
                            {{ $transactions->appends(request()->query())->links() }}
                        </div>
                    </div>

                </div> <!-- End Layout Container -->
            </div>
        </div>
    </div>

    <!-- Details / Edit modal -->
    <div id="transactionModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <div id="modal-body">
                <p>Modal...</p>
            </div>
        </div>
    </div>
</x-app-layout>