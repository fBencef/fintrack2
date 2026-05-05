<form id="editSubcategoryForm" method="POST" class="p-1">
    @csrf
    @method('PUT')
    
    <h3 class="text-xl font-bold text-gray-800">Alkategória szerkesztése</h3>
    <hr class="my-4 border-gray-200">

    <div class="space-y-4">
        <!-- Name -->
        <div>
            <label for="edit_subcategory_name" class="block text-sm font-bold text-gray-700 mb-1">Alkategória neve:</label>
            <input type="text" name="subcategory_name" id="edit_subcategory_name" 
                value="{{ $subcategory->subcategory_name }}" required
                class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
        </div>

        <!-- Description -->
        <div>
            <label for="edit_subcategory_description" class="block text-sm font-bold text-gray-700 mb-1">Leírás:</label>
            <input type="text" name="subcategory_description" id="edit_subcategory_description" 
                value="{{ $subcategory->subcategory_description }}" placeholder="Opcionális leírás..."
                class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
        </div>
    </div>

    <!-- Buttons -->
    <div class="mt-8 flex justify-end gap-3">
        <button type="button" onclick="closeEditSubModal()" 
            class="px-5 py-2.5 bg-gray-100 text-gray-600 text-sm font-bold rounded-sm hover:bg-gray-200 transition">
            Mégse
        </button>
        <button type="submit" 
            class="px-8 py-2.5 bg-green-700 hover:bg-green-800 text-white text-sm font-bold rounded-sm shadow-md transition active:scale-95">
            Frissítés
        </button>
    </div>
</form>