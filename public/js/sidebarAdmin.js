document.addEventListener('DOMContentLoaded', function() {
    const homeNav = document.getElementById('nav-home');
    const productItemNav = document.getElementById('nav-product-item');

    // Fungsi untuk mengaktifkan dan menonaktifkan state
    function activateNav(activeNav, inactiveNav) {
        activeNav.classList.add('active');
        inactiveNav.classList.remove('active');
    }

    // Event listener untuk Home
    homeNav.addEventListener('click', function() {
        activateNav(homeNav, productItemNav);
    });

    // Event listener untuk Product Item
    productItemNav.addEventListener('click', function() {
        activateNav(productItemNav, homeNav);
    });

    // Cek URL saat halaman dimuat
    const currentPath = window.location.pathname;

    // Jika URL /admin/home atau /admin/employe maka aktifkan tombol sesuai Url
    if (currentPath === '/admin/home') {
        activateNav(homeNav, productItemNav);
    } else if (currentPath === '/admin/petugas') {
        activateNav(productItemNav, homeNav);
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const showFormBtn = document.getElementById('show-form-btn');
    const petugasForm = document.getElementById('petugas-form');
    const closeFormBtn = document.getElementById('close-form-btn');
    const editPetugasForm = document.getElementById('edit-petugas-form');
    const closeEditFormBtn = document.getElementById('close-edit-form-btn');

    // Show create form
    showFormBtn.addEventListener('click', function() {
        petugasForm.classList.add('show');
    });

    // Hide create form
    closeFormBtn.addEventListener('click', function() {
        petugasForm.classList.remove('show');
    });

    // Hide edit form
    closeEditFormBtn.addEventListener('click', function() {
        editPetugasForm.classList.remove('show');
    });

document.querySelectorAll('.edit-button').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        const row = button.closest('tr');
        const email = row.querySelector('td:nth-child(2)').innerText;
        const username = row.querySelector('td:nth-child(3)').innerText;
        const id = button.getAttribute('data-id'); // Fetching the correct ID

        // Update form action with the correct ID
        const action = `/admin/petugas/${id}`; // Correctly form the URL using the ID
        document.getElementById('edit-email').value = email;
        document.getElementById('edit-username').value = username;
        document.getElementById('edit-form').action = action; // Setting the form action dynamically

        editPetugasForm.classList.add('show');
    });
});


});
