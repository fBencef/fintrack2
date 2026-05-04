<form action="{{ route('subcategories.store') }}" method="POST" class="p-1">
    @csrf
    <h3 class="text-xl font-bold text-gray-800">Új alkategória</h3>
    <hr class="my-4 border-gray-200">

    <!-- Parent Category Info -->
    <p class="text-sm text-gray-600 mb-6 bg-gray-50 p-2 rounded-sm border-l-4 border-green-600">
        Fő kategória: <span id="sub_parent_name" class="font-bold text-gray-900"></span>
    </p>
    
    <input type="hidden" name="category_id" id="parent_category_id">

    <div class="space-y-4">
        <!-- Subcategory Name -->
        <div>
            <label for="subcategory_name" class="block text-sm font-bold text-gray-700 mb-1">Alkategória neve:</label>
            <input type="text" id="subcategory_name" name="subcategory_name" placeholder="pl. Zöldség vagy Rezsi" required
                class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
        </div>

        <!-- Subcategory Description -->
        <div>
            <label for="subcategory_description" class="block text-sm font-bold text-gray-700 mb-1">Leírás:</label>
            <input type="text" id="subcategory_description" name="subcategory_description" placeholder="Opcionális megjegyzés..."
                class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
        </div>
    </div>

    <!-- Buttons -->
    <div class="mt-8 flex justify-end gap-3">
        <button type="button" onclick="closeSubModal()" 
            class="px-5 py-2.5 bg-gray-100 text-gray-600 text-sm font-bold rounded-sm hover:bg-gray-200 transition">
            Mégse
        </button>
        <button type="submit" 
            class="px-8 py-2.5 bg-green-700 hover:bg-green-800 text-white text-sm font-bold rounded-sm shadow-md transition active:scale-95">
            Mentés
        </button>
    </div>
</form>