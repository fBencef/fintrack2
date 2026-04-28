window.openCreateCategoryModal = function() {
    document.getElementById('categoryModal').style.display = 'block';
}

window.closeCategoryModal = function() {
    document.getElementById('categoryModal').style.display = 'none';
}

window.openSubModal = function(parentId, parentName) {
    // Fill parent id parent name
    document.getElementById('parent_category_id').value = parentId;
    document.getElementById('sub_parent_name').innerText = parentName;
    
    document.getElementById('subcategoryModal').style.display = 'block';
}

window.closeSubModal = function() {
    document.getElementById('subcategoryModal').style.display = 'none';
}

window.openEditCategoryModal = function(category) {
    document.getElementById('edit_category_name').value = category.category_name;
    document.getElementById('edit_category_direction').value = category.category_direction;
    document.getElementById('edit_category_description').value = category.category_description || '';
    
    // Set the form action dynamically
    document.getElementById('editCategoryForm').action = `/settings/categories/${category.category_id}`;
    document.getElementById('editCategoryModal').style.display = 'block';
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