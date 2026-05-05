@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Beállítások') }}
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

    <!-- CATEGORIES -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold">Kategóriák</h3>
                    <button onclick="openCreateCategoryModal()" class="bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-4 rounded">
                        + Új kategória
                    </button>
                </div>

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-center">
                            <th class="p-3">Név</th>
                            <th class="p-3">Típus</th>
                            <th class="p-3">Leírás</th>
                            <th class="p-3">Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr class="bg-gray-50 border-b border-gray-200 font-semibold" data-category="cat-{{ $category->category_id }}">
                                <td class="p-3">
                                    @if($category->subcategories->count() > 0)
                                        <span class="table-expand cursor-pointer user-select-none mr-2"> ⯈ </span>
                                    @else
                                        <span class="mr-6"></span> @endif
                                    {{ $category->category_name }}
                                </td>
                                <td class="p-3">
                                    @if($category->category_direction == '-')
                                        <span>(-) Kiadás</span>
                                    @elseif($category->category_direction == '/')
                                        <span>(+/-) Kétirányú</span>
                                    @else
                                        <span>(+) Bevétel</span>
                                    @endif
                                </td>
                                <td class="p-3 text-sm text-gray-600">{{ $category->category_description ?? '-' }}</td>
                                <td class="p-3 text-right space-x-2">
                                    <div class="flex justify-end items-center gap-2">
                                        <button onclick="window.openSubModal({{ $category->category_id }}, '{{ $category->category_name }}')" class="text-green-700 hover:underline text-base font-medium">+ Alkategória</button>
                                        <button onclick="window.openEditCategoryModal({{ $category->category_id }})" class="text-gray-400 hover:text-green-800 transition-colors p-2 hover:bg-indigo-50 rounded-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                        </button>
                                        <form action="{{ route('categories.destroy', $category->category_id) }}" method="POST" class="inline" onsubmit="return confirm('Biztosan törlöd?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-700 hover:text-red-900 transition-colors p-2 hover:bg-rose-50 rounded-lg">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            @foreach($category->subcategories as $sub)
                                <tr class="toggle_subcategory border-b border-gray-100 hover:bg-gray-50" 
                                    data-parent="cat-{{ $category->category_id }}" 
                                    style="display: none;">
                                    <td class="p-2 pl-12 text-sm text-gray-700 italic">
                                        <span class="text-gray-400">└─</span> {{ $sub->subcategory_name }}
                                    </td>
                                    <td class="p-2 text-xs text-gray-400 uppercase tracking-widest">Alkategória</td>
                                    <td class="p-2 text-sm text-gray-500">{{ $sub->subcategory_description ?? '-' }}</td>
                                    <td class="p-2 text-left space-x-2">
                                        <div class="flex justify-end items-end">
                                            <button onclick="window.openEditSubModal({{ $sub->subcategory_id }})" class="text-gray-400 hover:text-green-800 transition-colors p-2 hover:bg-indigo-50 rounded-sm">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <form action="{{ route('subcategories.destroy', $sub->subcategory_id) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-700 hover:text-red-900 transition-colors p-2 hover:bg-rose-50 rounded-lg">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- ACCOUNTS -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold">Számlák</h3>
                    <button onclick="window.openCreateAccountModal()" class="bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-4 rounded">
                        + Új számla
                    </button>
                </div>

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-center">
                            <th class="p-3 w-1/2">Megnevezés</th>
                            <th class="p-3">Pénznem</th>
                            <th class="p-3">Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accounts as $account)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="p-3 font-semibold text-gray-800">{{ $account->account_name }}</td>
                                <td class="p-3 text-gray-800">
                                    {{ $account->currency->currency_name }} ({{ $account->currency->currency_sign }})
                                </td>
                                <td class="p-3 text-right space-x-2">
                                    <div class="flex justify-end items-end">
                                        <button onclick="window.openEditAccountModal({{ $account->account_id }})" class="text-gray-400 hover:text-green-800 transition-colors p-2 hover:bg-indigo-50 rounded-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                        </button>
                                        <form action="{{ route('accounts.destroy', $account->account_id) }}" method="POST" class="inline" onsubmit="return confirm('Biztosan törlöd ezt a számlát? Figyelem: A kapcsolódó tranzakciók is törlődnek!')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-700 hover:text-red-900 transition-colors p-2 hover:bg-rose-50 rounded-lg">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- CURRENCIES -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold">Pénznemek</h3>
                    <button onclick="window.openCreateCurrencyModal()" class="bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-4 rounded">
                        + Új pénznem
                    </button>
                </div>

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-center">
                            <th class="p-3">Név</th>
                            <th class="p-3">Rövidítés</th>
                            <th class="p-3">Jel</th>
                            <th class="p-3">Alapértelmezett</th>
                            <th class="p-3">Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($currencies as $currency)
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <td class="p-3 font-semibold">{{ $currency->currency_name }}</td>
                                <td class="p-3">{{ $currency->currency_abbreviation }}</td>
                                <td class="p-3">{{ $currency->currency_sign }}</td>
                                <td class="p-3 text-center">
                                    @if($currency->is_default_currency)
                                        <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-sm bg-emerald-100 text-emerald-700 border border-blue-200">ALAPÉRTELMEZETT</span>
                                    @else
                                        <span class="text-gray-300">-</span>
                                    @endif
                                </td>
                                <td class="p-3 text-right space-x-2">
                                    <div class="flex justify-end items-end">
                                        <button onclick="window.openEditCurrencyModal({{ $currency->currency_id }})" class="text-gray-400 hover:text-green-800 transition-colors p-2 hover:bg-indigo-50 rounded-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        @if(!$currency->is_default_currency)
                                        <form action="{{ route('currencies.destroy', $currency->currency_id) }}" method="POST" class="inline" onsubmit="return confirm('Biztosan törlöd?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-700 hover:text-red-900 transition-colors p-2 hover:bg-rose-50 rounded-lg">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                        @else
                                        <button type="submit" class="text-gray-700 transition-colors p-2 rounded-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- DASHBOARD ITEMS -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-2">Vezérlőpult testreszabása</h3>
                <p class="text-sm text-gray-600 mb-6">Kapcsold be azokat a kártyákat, amelyeket látni szeretnél a főoldalon.</p>

                <form action="{{ route('settings.update_preferences') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="flex items-center p-4 border rounded-lg hover:bg-gray-50 cursor-pointer transition">
                            <input type="checkbox" name="prefs[monthly_spending]" value="1" 
                                {{ auth()->user()->prefers('monthly_spending') ? 'checked' : '' }} 
                                class="rounded border-gray-300 !text-green-600 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500" style="accent-color: #15803d;">
                            <div class="ml-4">
                                <span class="block font-medium text-gray-900">Havi költés</span>
                                <span class="block text-xs text-gray-500">Az aktuális hónap összesített kiadásai.</span>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border rounded-lg hover:bg-gray-50 cursor-pointer transition">
                            <input type="checkbox" name="prefs[category_chart]" value="1" 
                                {{ auth()->user()->prefers('category_chart') ? 'checked' : '' }} 
                                class="rounded border-gray-300 !text-green-600 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500" style="accent-color: #15803d;">
                            <div class="ml-4">
                                <span class="block font-medium text-gray-900">Kategória megoszlás</span>
                                <span class="block text-xs text-gray-500">Grafikus kimutatás a kiadási kategóriákról.</span>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border rounded-lg hover:bg-gray-50 cursor-pointer transition">
                            <input type="checkbox" name="prefs[recent_transactions]" value="1" 
                                {{ auth()->user()->prefers('recent_transactions') ? 'checked' : '' }} 
                                class="rounded border-gray-300 !text-green-600 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500" style="accent-color: #15803d;">
                            <div class="ml-4">
                                <span class="block font-medium text-gray-900">Legutóbbi tranzakciók</span>
                                <span class="block text-xs text-gray-500">A legfrissebb pénzmozgások listája.</span>
                            </div>
                        </label>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button class="inline-flex items-center px-5 py-2.5 bg-green-700 hover:bg-green-800 text-white text-xs font-bold rounded transition-all shadow-sm hover:shadow-lg active:scale-95 uppercase tracking-wider">Vezérlőpult mentése</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- MODALS -->
    <!-- Add categories -->
    <div id="categoryModal" class="modal-overlay" style="display:none;">
        <div class="modal-content">
            <span class="close-btn" onclick="closeCategoryModal()">&times;</span>
            <div id="categoryModalBody"></div>
        </div>
    </div>

    <!-- Add subcategories -->
    <div id="subcategoryModal" class="modal-overlay" style="display:none;">
        <div class="modal-content">
            <span class="close-btn" onclick="closeSubModal()">&times;</span>
            <div id="subcategoryModalBody"></div>
        </div>
    </div>

    <!-- Edit categories -->
    <div id="editCategoryModal" class="modal-overlay" style="display:none;">
        <div class="modal-content">
            <span class="close-btn" onclick="closeEditCategoryModal()">&times;</span>
            <div id="categoryEditBody"></div>
        </div>
    </div>

    <!-- Edit subcategories -->
    <div id="editSubcategoryModal" class="modal-overlay" style="display:none;">
        <div class="modal-content">
            <span class="close-btn" onclick="closeEditSubcategoryModal()">&times;</span>
            <div id="subcategoryEditBody"></div>
        </div>
    </div>

    <!-- Add accounts -->
    <div id="accountModal" class="modal-overlay" style="display:none;">
        <div class="modal-content">
            <span class="close-btn" onclick="closeAccountModal()">&times;</span>
            <div id="accountModalBody"></div>
        </div>
    </div>


    <!-- Edit accounts -->
    <div id="editAccountModal" class="modal-overlay" style="display:none;">
        <div class="modal-content">
            <span class="close-btn" onclick="closeEditAccountModal()">&times;</span>
            <div id="accountEditBody"></div>
        </div>
    </div>

    <!-- Add currency -->
    <div id="currencyModal" class="modal-overlay" style="display:none;">
        <div class="modal-content">
            <span class="close-btn" onclick="closeCurrencyModal()">&times;</span>
            <div id="currencyModalBody"></div>
        </div>
    </div>

    <!-- Edit currency -->
    <div id="editCurrencyModal" class="modal-overlay" style="display:none;">
        <div class="modal-content">
            <span class="close-btn" onclick="closeEditCurrencyModal()">&times;</span>
            <div id="currencyEditBody"></div>
        </div>
    </div>

</x-app-layout>