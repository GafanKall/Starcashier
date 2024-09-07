document.addEventListener('DOMContentLoaded', function () {
    // Mengaktifkan dan menonaktifkan state nav
    const homeNav = document.getElementById('nav-home');
    const productItemNav = document.getElementById('nav-product-item');
    const categoryNav = document.getElementById('nav-category');

    function activateNav(activeNav, ...inactiveNavs) {
        activeNav.classList.add('active');
        inactiveNavs.forEach(nav => nav.classList.remove('active'));
    }

    homeNav.addEventListener('click', () => activateNav(homeNav, productItemNav, categoryNav));
    productItemNav.addEventListener('click', () => activateNav(productItemNav, homeNav, categoryNav));
    categoryNav.addEventListener('click', () => activateNav(categoryNav, homeNav, productItemNav));

    const currentPath = window.location.pathname;

    if (currentPath === '/petugas/home') {
        activateNav(homeNav, productItemNav, categoryNav);
        // Set "All" button as active on page load
        const allButton = document.querySelector('.category-menu button[data-category="all"]');
        if (allButton) {
            allButton.classList.add('active');
        }
    } else if (currentPath === '/petugas/product') {
        activateNav(productItemNav, homeNav, categoryNav);
    } else if (currentPath === '/petugas/category') {
        activateNav(categoryNav, homeNav, productItemNav);
    }

    // Menangani klik kategori
    const categoryButtons = document.querySelectorAll('.category-menu button');
    const productItems = document.querySelectorAll('.product-item');

    // Set default button "All" as active
    const defaultCategoryButton = document.querySelector('.category-menu button[data-category="all"]');
    if (defaultCategoryButton) {
        defaultCategoryButton.classList.add('active');
    }

    categoryButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons
            categoryButtons.forEach(btn => btn.classList.remove('active'));

            // Add active class to the clicked button
            button.classList.add('active');

            const categoryId = button.getAttribute('data-category');

            // Show or hide products based on selected category
            productItems.forEach(item => {
                const productCategory = item.getAttribute('data-category');
                if (categoryId === 'all' || productCategory === categoryId) {
                    item.style.display = 'block';
                    item.classList.add('active'); // Add active class for design effect
                } else {
                    item.style.display = 'none';
                    item.classList.remove('active'); // Remove active class
                }
            });
        });
    });

    // Menangani klik tombol Add To Cart
    const transactionList = document.querySelector('.product-list');
    const subtotalElement = document.querySelector('.list-subtotal .row2 h3:nth-child(2)');
    let cart = [];

    productItems.forEach(item => {
        const addToCartButton = item.querySelector('.add-to-cart button');

        addToCartButton.addEventListener('click', (e) => {
            e.stopPropagation();
            const productName = item.getAttribute('data-name');
            const productPrice = parseFloat(item.getAttribute('data-price'));
            let productStock = parseInt(item.getAttribute('data-stock'));
            const productImage = item.getAttribute('data-image');

            const existingProduct = cart.find(product => product.name === productName);

            if (existingProduct) {
                if (existingProduct.quantity < productStock) {
                    existingProduct.quantity += 1;
                    productStock -= 1;
                } else {
                    alert("Product stock limit reached.");
                }
            } else {
                if (productStock > 0) {
                    cart.push({
                        name: productName,
                        price: productPrice,
                        stock: productStock - 1,
                        image: productImage,
                        quantity: 1
                    });
                } else {
                    alert("Out of stock.");
                }
            }

            item.setAttribute('data-stock', productStock);
            item.querySelector('h3').textContent = `Stock: ${productStock}`;
            updateCart();
        });
    });

    function updateCart() {
        transactionList.innerHTML = '';

        cart.forEach(product => {
            const productElement = document.createElement('div');
            productElement.classList.add('list-order');
            productElement.innerHTML = `
                <div class="image-product">
                    <img src="${product.image}" alt="${product.name}">
                </div>
                <div class="total">
                    <div class="total-product">
                        <h3>${product.name}</h3>
                    </div>
                    <div class="product-plus-minus">
                        <button class="minus">-</button>
                        <h3>(${product.quantity})</h3>
                        <button class="plus">+</button>
                    </div>
                </div>
                <div class="subtotal">
                    <p>Rp. ${(product.price * product.quantity).toLocaleString('id-ID')}</p>
                </div>
            `;
            transactionList.appendChild(productElement);

            // Menangani klik tombol minus
            productElement.querySelector('.minus').addEventListener('click', () => {
                const existingProduct = cart.find(p => p.name === product.name);
                if (existingProduct && existingProduct.quantity > 1) {
                    existingProduct.quantity -= 1;
                    existingProduct.stock += 1; // Tambah stok karena pengurangan quantity
                    item.setAttribute('data-stock', existingProduct.stock);
                } else {
                    cart = cart.filter(p => p.name !== product.name);
                }
                updateCart();
            });

            // Menangani klik tombol plus
            productElement.querySelector('.plus').addEventListener('click', () => {
                if (product.stock > 0) {
                    product.quantity += 1;
                    product.stock -= 1; // Kurangi stok karena penambahan quantity
                    item.setAttribute('data-stock', product.stock);
                    updateCart();
                } else {
                    alert('Stok tidak mencukupi');
                }
            });
        });

        // Hitung subtotal
        const subtotal = cart.reduce((sum, product) => sum + (product.price * product.quantity), 0);
        subtotalElement.textContent = `Rp. ${subtotal.toLocaleString('id-ID')}`;
    }

});

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-input');
    const productItems = document.querySelectorAll('.product-item');

    function filterProducts(query) {
        query = query.toLowerCase();
        productItems.forEach(item => {
            const productName = item.querySelector('h1').textContent.toLowerCase();
            if (productName.includes(query)) {
                item.style.display = 'block'; // Show product
            } else {
                item.style.display = 'none'; // Hide product
            }
        });
    }

    searchInput.addEventListener('input', function () {
        filterProducts(searchInput.value);
    });
});


// Plus Minus
document.querySelectorAll('.minus-btn').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-id');
        const quantityInput = this.nextElementSibling;
        let quantity = parseInt(quantityInput.value);

        if (quantity > 1) {
            quantity--;
            quantityInput.value = quantity;
            updateStock(productId, quantity);
        }
    });
});

document.querySelectorAll('.plus-btn').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-id');
        const quantityInput = this.previousElementSibling;
        let quantity = parseInt(quantityInput.value);
        const maxStock = parseInt(this.closest('.product-item').getAttribute('data-stock'));

        if (quantity < maxStock) {
            quantity++;
            quantityInput.value = quantity;
            updateStock(productId, quantity);
        } else {
            alert('Stock tidak mencukupi');
        }
    });
});

function updateStock(productId, quantity) {
    fetch(`/product/update-stock/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log(`Stock updated: ${data.stock}`);
        } else {
            alert('Gagal memperbarui stok');
        }
    });
}
