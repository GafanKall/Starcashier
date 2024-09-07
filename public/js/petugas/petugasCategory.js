document.addEventListener('DOMContentLoaded', function() {
    const homeNav = document.getElementById('nav-home');
    const productItemNav = document.getElementById('nav-product-item');
    const categoryNav = document.getElementById('nav-category');
    // Fungsi untuk mengaktifkan dan menonaktifkan state
    function activateNav(activeNav, inactiveNav) {
        activeNav.classList.add('active');
        inactiveNav.classList.remove('active');
    }

    // Event listener untuk Home
    homeNav.addEventListener('click', function() {
        activateNav(homeNav, productItemNav, categoryNav);
    });

    // Event listener untuk Product Item
    productItemNav.addEventListener('click', function() {
        activateNav(productItemNav, homeNav, categoryNav);
    });

    categoryNav.addEventListener('click', function() {
        activateNav(categoryNav, homeNav, productItemNav);
    });

    // Cek URL saat halaman dimuat
    const currentPath = window.location.pathname;

    // Jika URL adalah /admin/home, aktifkan tombol Home
    if (currentPath === '/petugas/home') {
        activateNav(homeNav, productItemNav);
    } else if (currentPath === '/petugas/product') {
        activateNav(productItemNav, homeNav);
    } else if (currentPath === '/petugas/category') {
        activateNav(categoryNav, homeNav, productItemNav);
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const showFormButton = document.getElementById('show-form-btn');
    const closeFormButton = document.getElementById('close-form-btn');
    const categoryForm = document.getElementById('category-form');
    const closeEditFormBtn = document.getElementById('close-edit-form-btn');

    // Show the form with animation
    showFormButton.addEventListener('click', function() {
        categoryForm.classList.add('show');
        categoryForm.style.display = 'block';  // Ensure it's visible
    });

    // Hide the form with animation
    closeFormButton.addEventListener('click', function() {
        categoryForm.classList.remove('show');
        categoryForm.style.display = 'none';  // Hide after animation
    });

    // Hide the edit form
    closeEditFormBtn.addEventListener('click', function() {
        document.getElementById('edit-category-form').classList.remove('show');
        document.getElementById('edit-category-form').style.display = 'none';
    });

    // Show the edit form and populate fields
    window.showEditForm = function(id, category_name) {
        const editForm = document.getElementById('edit-category-form');
        editForm.style.display = 'block';
        editForm.classList.add('show');

        // Set form action dynamically
        document.getElementById('edit-form').action = `/petugas/category/${id}`;

        // Set input values dynamically
        document.getElementById('edit_category_name').value = category_name;
    };


});

