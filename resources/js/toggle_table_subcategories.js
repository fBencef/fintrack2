document.addEventListener('DOMContentLoaded', () => {
    // Select all expand buttons
    const expandButtons = document.querySelectorAll('.table-expand');

    expandButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Get the category name of the parent row
            const parentRow = this.closest('tr');
            const category = parentRow.getAttribute('data-category');
            
            // Find all sub-rows that belong to this category
            const subRows = document.querySelectorAll(`tr.toggle_subcategory[data-parent="${category}"]`);
            
            subRows.forEach(row => {
                // Toggle between hidden and visible
                if (row.style.display === 'none' || row.style.display === '') {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });

            // Toggle the arrow icon
            if (subRows.length > 0) {
                this.textContent = this.textContent.includes('⯈') ? ' ⯆ ' : ' ⯈ ';
            }
        });
    });
});