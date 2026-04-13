// Dyanmic subcategory dropdown
document.addEventListener('change', function (e) {
    if (e.target && e.target.id === 'modal_category_select') {
        const categoryId = e.target.value;
        const subcategorySelect = document.getElementById('modal_subcategory_select');

        // Clear existing options
        subcategorySelect.innerHTML = '<option value="">-- Nincs alkategória --</option>';

        if (categoryId) {
            fetch(`/api/categories/${categoryId}/subcategories`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(sub => {
                        const option = document.createElement('option');
                        option.value = sub.subcategory_id;
                        option.textContent = sub.subcategory_name;
                        subcategorySelect.appendChild(option);
                    });
                });
        }
    }
    if (e.target && e.target.id === 'all_category_select') {
        const categoryId = e.target.value;
        const subcategorySelect = document.getElementById('all_subcategory_select');

        // Clear existing options
        subcategorySelect.innerHTML = '<option value="">Minden alkategória</option>';

        if (categoryId) {
            fetch(`/api/categories/${categoryId}/subcategories`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(sub => {
                        const option = document.createElement('option');
                        option.value = sub.subcategory_id;
                        option.textContent = sub.subcategory_name;
                        subcategorySelect.appendChild(option);
                    });
                });
        }
    }
});