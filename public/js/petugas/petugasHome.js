document.addEventListener('DOMContentLoaded', function () {
    // Aktivasi dan penonaktifan status navigasi sidebar
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
        const allButton = document.querySelector('.category-menu button[data-category="all"]');
        if (allButton) {
            allButton.classList.add('active');
        }
    } else if (currentPath === '/petugas/product') {
        activateNav(productItemNav, homeNav, categoryNav);
    } else if (currentPath === '/petugas/category') {
        activateNav(categoryNav, homeNav, productItemNav);
    }

    // Menangani klik tombol kategori
    const categoryButtons = document.querySelectorAll('.category-menu button');
    const productItems = document.querySelectorAll('.product-item');

    categoryButtons.forEach(button => {
        button.addEventListener('click', () => {
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            const categoryId = button.getAttribute('data-category');
            productItems.forEach(item => {
                const productCategory = item.getAttribute('data-category');
                item.style.display = (categoryId === 'all' || productCategory === categoryId) ? 'block' : 'none';
            });
        });
    });

    // Menangani klik tombol Add to Cart
    const transactionList = document.querySelector('.product-list');
    const subtotalElement = document.querySelector('.list-subtotal .row2 h3:nth-child(2)');
    let cart = [];

    function updateCart() {
        transactionList.innerHTML = '';

        cart.forEach(product => {
            const productElement = document.createElement('div');
            productElement.classList.add('list-order');
            productElement.innerHTML = `
                <div class="total">
                    <div class="total-product">
                        <h3>${product.name}</h3>
                    </div>
                    <div class="product-plus-minus">
                        <button class="minus" data-name="${product.name}">-</button>
                        <h3>(${product.quantity})</h3>
                        <button class="plus" data-name="${product.name}">+</button>
                    </div>
                </div>
                <div class="subtotal">
                    <p>${(product.price * product.quantity).toLocaleString('id-ID')}</p>
                </div>
            `;
            transactionList.appendChild(productElement);

            productElement.querySelector('.minus').addEventListener('click', () => {
                const existingProduct = cart.find(p => p.name === product.name);
                if (existingProduct && existingProduct.quantity > 1) {
                    existingProduct.quantity -= 1;
                    existingProduct.stock += 1;
                } else {
                    cart = cart.filter(p => p.name !== product.name);
                }
                updateCart();
            });

            productElement.querySelector('.plus').addEventListener('click', () => {
                if (product.stock > 0) {
                    product.quantity += 1;
                    product.stock -= 1;
                    updateCart();
                } else {
                    alert('Stok tidak mencukupi');
                }
            });
        });

        const subtotal = cart.reduce((sum, product) => sum + (product.price * product.quantity), 0);
        subtotalElement.textContent = `Rp. ${subtotal.toLocaleString('id-ID')}`;
    }

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

            // Disable Add To Cart button
            addToCartButton.disabled = true;
        });
    });

    // Menangani pencarian produk
    const searchInput = document.getElementById('search-input');

    function filterProducts(query) {
        query = query.toLowerCase();
        productItems.forEach(item => {
            const productName = item.querySelector('h1').textContent.toLowerCase();
            item.style.display = productName.includes(query) ? 'block' : 'none';
        });
    }

    searchInput.addEventListener('input', function () {
        filterProducts(searchInput.value);
    });

    // Menangani klik tombol Charge
    const chargeButton = document.querySelector('.charge');
    const chargeForm = document.getElementById('charge-form');
    const cancelButton = chargeForm.querySelector('.cancel-button');

    chargeButton.addEventListener('click', () => {
        const formItemsContainer = chargeForm.querySelector('#order-details');
        formItemsContainer.innerHTML = '';

        const productsInput = document.createElement('input');
        productsInput.type = 'hidden';
        productsInput.name = 'products';
        productsInput.value = JSON.stringify(cart);
        chargeForm.appendChild(productsInput);

        cart.forEach(product => {
            const productElement = document.createElement('div');
            productElement.classList.add('form-order');
            productElement.innerHTML = `
                <div class="form-total">
                    <div class="form-total-product">
                        <p>${product.name} (${product.quantity})</p>
                    </div>
                    <div class="form-subtotal">
                        <p>Rp. ${(product.price * product.quantity).toLocaleString('id-ID')}</p>
                    </div>
                </div>
            `;
            formItemsContainer.appendChild(productElement);
        });

        const formSubtotal = chargeForm.querySelector('#total-amount');
        const total = cart.reduce((sum, product) => sum + (product.price * product.quantity), 0);
        formSubtotal.value = total;

        chargeForm.style.display = 'block';
    });


    cancelButton.addEventListener('click', () => {
        chargeForm.style.display = 'none';
    });
});

$(document).ready(function() {
    // Data produk yang dipilih, bisa diambil dari suatu list di halaman
    const products = [
        { id: 1, quantity: 2 },
        { id: 2, quantity: 3 }
    ];

    // Ketika tombol submit diklik
    $('#submitTransaction').on('click', function(e) {
        e.preventDefault(); // Mencegah form reload

        // Ambil nilai total amount dan total payment dari hidden input
        const totalAmount = $('#total_amount').val();
        const totalPayment = $('#total_payment').val();

        // Kirim data via AJAX
        $.ajax({
            url: "{{ route('transaction.submit') }}",  // Ganti dengan route yang sesuai
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                products: JSON.stringify(products),
                total_amount: totalAmount,
                total_payment: totalPayment,
            },
            success: function(response) {
                if(response.success) {
                    alert('Transaction successful!');
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Something went wrong, please try again.');
            }
        });
    });
});
