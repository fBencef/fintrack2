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
                    <h3 class="text-lg font-bold">Kategóriák kezelése</h3>
                    <button onclick="openCreateCategoryModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        + Új kategória
                    </button>
                </div>

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
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
                                    <button onclick="window.openSubModal({{ $category->category_id }}, '{{ $category->category_name }}')" class="text-blue-600 hover:underline text-sm font-medium">+ Alkategória</button>
                                    <button onclick="window.openEditCategoryModal({{ json_encode($category) }})" class=" hover:underline text-sm font-medium">Szerkesztés</button>
                                    <form action="{{ route('categories.destroy', $category->category_id) }}" method="POST" class="inline" onsubmit="return confirm('Biztosan törlöd?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-sm font-medium">Törlés</button>
                                    </form>
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
                                    <td class="p-2 text-right space-x-2">
                                        <button onclick="window.openEditSubModal({{ json_encode($sub) }})" class="hover:underline text-xs font-medium">Szerkesztés</button>
                                        <form action="{{ route('subcategories.destroy', $sub->subcategory_id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-600 text-xs font-medium">Eltávolítás</button>
                                        </form>
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
                    <h3 class="text-lg font-bold">Pénztárcák és Számlák</h3>
                    <button onclick="window.openCreateAccountModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        + Új számla
                    </button>
                </div>

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left border-b-2 border-gray-200">
                            <th class="p-3 w-1/2">Megnevezés</th>
                            <th class="p-3">Pénznem</th>
                            <th class="p-3 text-right">Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accounts as $account)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="p-3 font-semibold text-gray-800">{{ $account->account_name }}</td>
                                <td class="p-3 text-gray-600">
                                    {{ $account->currency->currency_name }} ({{ $account->currency->currency_sign }})
                                </td>
                                <td class="p-3 text-right space-x-2">
                                    <button onclick="window.openEditAccountModal({{ json_encode($account) }})" class="hover:underline text-sm font-medium">Szerkesztés</button>
                                    <form action="{{ route('accounts.destroy', $account->account_id) }}" method="POST" class="inline" onsubmit="return confirm('Biztosan törlöd ezt a számlát? Figyelem: A törlés befolyásolhatja a kapcsolódó tranzakciókat!')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-sm font-medium">Törlés</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- MODALS -->
    <!-- Add categories -->
    <div id="categoryModal" class="modal" style="display:none; position:fixed; z-index:100; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
        <div style="background:white; margin:10% auto; padding:20px; width:40%; border-radius:8px;">
            <h3 class="text-xl font-bold mb-4">Új kategória</h3>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1">Kategória neve</label>
                    <input type="text" name="category_name" class="w-full border rounded p-2" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Típus</label>
                    <select name="category_direction" class="w-full border rounded p-2">
                        <option value="-">Kiadás (-)</option>
                        <option value="+">Bevétel (+)</option>
                        <option value="/">Kétirányú (+/-)</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Leírás</label>
                    <input type="text" name="category_description" class="w-full border rounded p-2">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeCategoryModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Mégse</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Mentés</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add subcategories -->
    <div id="subcategoryModal" class="modal-overlay" style="display:none;">
    <div class="modal-content">
        <span class="close-btn" onclick="window.closeSubModal()">&times;</span>
        <h3 class="text-xl font-bold mb-4">Új alkategória</h3>
        <p class="text-sm text-gray-600 mb-4">Fő kategória: <span id="sub_parent_name" class="font-bold"></span></p>
        
        <form action="{{ route('subcategories.store') }}" method="POST">
            @csrf
            <input type="hidden" name="category_id" id="parent_category_id">
            
            <div class="mb-4">
                <x-input-label for="subcategory_name" value="Alkategória neve" />
                <x-text-input id="subcategory_name" name="subcategory_name" class="block mt-1 w-full" required />
                <br>
                <x-input-label for="subcategory_description" value="Leírás" />
                <x-text-input id="subcategory_description" name="subcategory_description" class="block mt-1 w-full" />
            </div>

            <div class="flex justify-end gap-2">
                <x-secondary-button type="button" onclick="window.closeSubModal()">Mégse</x-secondary-button>
                <x-primary-button type="submit">Mentés</x-primary-button>
            </div>
        </form>
    </div>
    </div>

    <!-- Edit categories -->
    <div id="editCategoryModal" class="modal" style="display:none; position:fixed; z-index:100; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
        <div style="background:white; margin:10% auto; padding:20px; width:40%; border-radius:8px;">
            <h3 class="text-xl font-bold mb-4">Kategória szerkesztése</h3>
            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block mb-1">Kategória neve</label>
                    <input type="text" name="category_name" id="edit_category_name" class="w-full border rounded p-2" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Típus</label>
                    <select name="category_direction" id="edit_category_direction" class="w-full border rounded p-2">
                        <option value="-">Kiadás (-)</option>
                        <option value="+">Bevétel (+)</option>
                        <option value="/">Kétirányú (+/-)</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Leírás</label>
                    <input type="text" name="category_description" id="edit_category_description" class="w-full border rounded p-2">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEditCategoryModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Mégse</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Frissítés</button>
                </div>
            </form>
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

</x-app-layout>