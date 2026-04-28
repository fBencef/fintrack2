window.openCreateCategoryModal = function() {
    document.getElementById('categoryModal').style.display = 'block';
}

window.closeCategoryModal = function() {
    document.getElementById('categoryModal').style.display = 'none';
}

window.openSubModal = function(parentId, parentName) {
    // Fill the hidden ID field and the visual label
    document.getElementById('parent_category_id').value = parentId;
    document.getElementById('sub_parent_name').innerText = parentName;
    
    document.getElementById('subcategoryModal').style.display = 'block';
}

// Function to close Subcategory Modal
window.closeSubModal = function() {
    document.getElementById('subcategoryModal').style.display = 'none';
}