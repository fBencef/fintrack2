<form id="editCategoryForm" method="POST" class="p-1">
    @csrf
    @method('PUT')
    
    <h3 class="text-xl font-bold text-gray-800">Kategória szerkesztése</h3>
    <hr class="my-4 border-gray-200">

    <div class="space-y-4">
        <!-- Name -->
        <div>
            <label for="edit_category_name" class="block text-sm font-bold text-gray-700 mb-1">Kategória neve:</label>
            <input type="text" name="category_name" id="edit_category_name" required
                class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
        </div>

        <!-- Direction -->
        <div>
            <label for="edit_category_direction" class="block text-sm font-bold text-gray-700 mb-1">Típus:</label>
            <select name="category_direction" id="edit_category_direction"
                class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
                <option value="-">Kiadás (-)</option>
                <option value="+">Bevétel (+)</option>
                <option value="/">Kétirányú (+/-)</option>
            </select>
        </div>

        <!-- Description -->
        <div>
            <label for="edit_category_description" class="block text-sm font-bold text-gray-700 mb-1">Leírás:</label>
            <input type="text" name="category_description" id="edit_category_description" placeholder="Opcionális leírás..."
                class="w-full rounded-sm border-gray-300 focus:border-green-600 focus:ring-2 focus:ring-green-600 outline-none shadow-sm text-sm p-1">
        </div>
    </div>

    <!-- Buttons -->
    <div class="mt-8 flex justify-end gap-3">
        <button type="button" onclick="closeEditCategoryModal()" 
            class="px-5 py-2.5 bg-gray-100 text-gray-600 text-sm font-bold rounded-sm hover:bg-gray-200 transition">
            Mégse
        </button>
        <button type="submit" 
            class="px-8 py-2.5 bg-green-700 hover:bg-green-800 text-white text-sm font-bold rounded-sm shadow-md transition active:scale-95">
            Frissítés
        </button>
    </div>
</form>