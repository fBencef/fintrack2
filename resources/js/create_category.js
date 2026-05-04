window.openCreateCategoryModal = function() {
    const modal = document.getElementById('categoryModal');
    const body = document.getElementById('categoryModalBody');
    modal.style.display = 'block';
    
    fetch('/categories/create')
        .then(response => response.text())
        .then(html => {
            body.innerHTML = html;
        });
}

window.closeCategoryModal = function() {
    document.getElementById('categoryModal').style.display = 'none';
}

window.openSubModal = function(parentId, parentName) {
    // Fill parent id parent name
    
    const modal = document.getElementById('subcategoryModal');
    const body = document.getElementById('subcategoryModalBody');
    modal.style.display = 'block';
    
    
    fetch('/subcategories/create')
    .then(response => response.text())
    .then(html => {
        body.innerHTML = html;
        document.getElementById('parent_category_id').value = parentId;
        document.getElementById('sub_parent_name').innerText = parentName;
    });

}

window.closeSubModal = function() {
    document.getElementById('subcategoryModal').style.display = 'none';
}

window.openEditCategoryModal = function(categoryId) {
    const modal = document.getElementById('categoryModal'); // Or your specific edit modal ID
    const body = document.getElementById('categoryModalBody');
    const form = document.getElementById('editCategoryForm');

    modal.style.display = 'block';

    fetch(`/categories/${categoryId}/edit`)
        .then(response => response.text())
        .then(html => {
            body.innerHTML = html;

            const editForm = document.getElementById('editCategoryForm');
            if (editForm) {
                editForm.action = `/categories/${categoryId}`;
            }
        })
}

window.closeEditCategoryModal = function() {
    document.getElementById('editCategoryModal').style.display = 'none';
}

window.openEditSubModal = function(sub) {
    document.getElementById('edit_subcategory_name').value = sub.subcategory_name;
    document.getElementById('edit_subcategory_description').value = sub.subcategory_description || '';
    
    document.getElementById('editSubcategoryForm').action = `/settings/subcategories/${sub.subcategory_id}`;
    document.getElementById('editSubcategoryModal').style.display = 'block';
}

window.closeEditSubModal = function() {
    document.getElementById('editSubcategoryModal').style.display = 'none';
}