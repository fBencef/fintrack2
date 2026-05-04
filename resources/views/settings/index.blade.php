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
                                        <button onclick="window.openEditCategoryModal({{ json_encode($category) }})" class="text-gray-400 hover:text-green-800 transition-colors p-2 hover:bg-indigo-50 rounded-sm">
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
                                            <button onclick="window.openEditSubModal({{ json_encode($sub) }})" class="text-gray-400 hover:text-green-800 transition-colors p-2 hover:bg-indigo-50 rounded-sm">
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
                                        <button onclick="window.openEditAccountModal({{ json_encode($account) }})" class="text-gray-400 hover:text-green-800 transition-colors p-2 hover:bg-indigo-50 rounded-sm">
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
                                        <button onclick="window.openEditCurrencyModal({{ json_encode($currency) }})" class="text-gray-400 hover:text-green-800 transition-colors p-2 hover:bg-indigo-50 rounded-sm">
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
            <span class="close-btn" onclick="closeEditModal()">&times;</span>
            <div id="categoryEditBody"></div>
        </div>
    </div>

    <!-- Edit subcategories -->
    <div id="editSubcategoryModal" class="modal" style="display:none; position:fixed; z-index:100; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
        <div style="background:white; margin:10% auto; padding:20px; width:40%; border-radius:8px;">
            <h3 class="text-xl font-bold mb-4">Alkategória szerkesztése</h3>
            <form id="editSubcategoryForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block mb-1">Alkategória neve</label>
                    <input type="text" name="subcategory_name" id="edit_subcategory_name" class="w-full border rounded p-2" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Leírás</label>
                    <input type="text" name="subcategory_description" id="edit_subcategory_description" class="w-full border rounded p-2">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEditSubModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Mégse</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Frissítés</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add accounts -->
    <div id="accountModal" class="modal" style="display:none; position:fixed; z-index:100; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
        <div style="background:white; margin:10% auto; padding:20px; width:35%; border-radius:8px;">
            <h3 class="text-xl font-bold mb-4">Új számla</h3>
            <form action="{{ route('accounts.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1">Megnevezés</label>
                    <input type="text" name="account_name" class="w-full border rounded p-2" placeholder="pl. Készpénz, Revolut" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Pénznem</label>
                    <select name="currency_id" class="w-full border rounded p-2">
                        @foreach($currencies as $currency)
                            <option value="{{ $currency->currency_id }}">{{ $currency->currency_name }} ({{ $currency->currency_sign }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="window.closeAccountModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Mégse</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Mentés</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Edit accounts -->
    <div id="editAccountModal" class="modal" style="display:none; position:fixed; z-index:100; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
        <div style="background:white; margin:10% auto; padding:20px; width:35%; border-radius:8px;">
            <h3 class="text-xl font-bold mb-4">Számla szerkesztése</h3>
            
            <form id="editAccountForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block mb-1 font-medium text-gray-700">Megnevezés</label>
                    <input type="text" name="account_name" id="edit_account_name" class="w-full border rounded p-2 focus:ring focus:ring-blue-200 outline-none" required>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="window.closeEditAccountModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Mégse</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-yellow-700 transition">Frissítés</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add currency -->
    <div id="currencyModal" class="modal" style="display:none; position:fixed; z-index:100; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
        <div style="background:white; margin:10% auto; padding:20px; width:35%; border-radius:8px;">
            <h3 class="text-xl font-bold mb-4">Új pénznem</h3>
            <form action="{{ route('currencies.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1">Név</label>
                    <input type="text" name="currency_name" class="w-full border rounded p-2" required placeholder="pl. Magyar forint">
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block mb-1">Rövidítés</label>
                        <input type="text" name="currency_abbreviation" class="w-full border rounded p-2" required placeholder="pl. HUF">
                    </div>
                    <div>
                        <label class="block mb-1">Jel</label>
                        <input type="text" name="currency_sign" class="w-full border rounded p-2" required placeholder="pl. Ft">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_default_currency" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm">
                        <span class="ml-2">Legyen ez az alapértelmezett</span>
                    </label>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="window.closeCurrencyModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Mégse</button>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Mentés</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit currency -->
    <div id="editCurrencyModal" class="modal" style="display:none; position:fixed; z-index:100; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
        <div style="background:white; margin:10% auto; padding:20px; width:35%; border-radius:8px;">
            <h3 class="text-xl font-bold mb-4">Pénznem szerkesztése</h3>
            
            <form id="editCurrencyForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block mb-1">Pénznem neve</label>
                    <input type="text" name="currency_name" id="edit_currency_name" class="w-full border rounded p-2 focus:ring focus:ring-indigo-200 outline-none" required>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block mb-1">Rövidítés (pl. EUR)</label>
                        <input type="text" name="currency_abbreviation" id="edit_currency_abbreviation" class="w-full border rounded p-2 focus:ring focus:ring-indigo-200 outline-none" required>
                    </div>
                    <div>
                        <label class="block mb-1">Jel (pl. €)</label>
                        <input type="text" name="currency_sign" id="edit_currency_sign" class="w-full border rounded p-2 focus:ring focus:ring-indigo-200 outline-none" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_default_currency" id="edit_is_default_currency" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ml-2">Legyen ez az alapértelmezett</span>
                    </label>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="window.closeEditCurrencyModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Mégse</button>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">Frissítés</button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>