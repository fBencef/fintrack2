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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900">Pénztárcák / Számlák</h3>
                    <p class="mt-1 text-sm text-gray-600">Itt kezelheted a rögzített bankszámláidat és készpénzes tárolóidat.</p>
                    
                    <ul class="mt-4 divide-y">
                        @foreach($accounts as $account)
                            <li class="py-2 flex justify-between">{{ $account->account_name }} <span>{{ $account->account_balance }}</span></li>
                        @endforeach
                    </ul>
                    <x-secondary-button class="mt-4">+ Új számla</x-secondary-button>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900">Kategóriák</h3>
                    <p class="mt-1 text-sm text-gray-600">Tranzakcióid csoportosításához használt kategóriák kezelése.</p>
                    </div>
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

</x-app-layout>