document.addEventListener('DOMContentLoaded', () => {
    // **Navigasi Sidebar**
    const navItems = {
        home: document.getElementById('nav-home'),
        product: document.getElementById('nav-product-item'),
        category: document.getElementById('nav-category'),
    };

    function activateNav(active, ...others) {
        active.classList.add('active');
        others.forEach(nav => nav.classList.remove('active'));
    }

    Object.entries(navItems).forEach(([key, nav]) => {
        nav.addEventListener('click', () => {
            activateNav(nav, ...Object.values(navItems).filter(item => item !== nav));
        });
    });

    const currentPath = window.location.pathname;
    if (currentPath.includes('/petugas/home')) {
        activateNav(navItems.home, navItems.product, navItems.category);
        document.querySelector('.category-menu button[data-category="all"]')?.classList.add('active');
    } else if (currentPath.includes('/petugas/product')) {
        activateNav(navItems.product, navItems.home, navItems.category);
    } else if (currentPath.includes('/petugas/category')) {
        activateNav(navItems.category, navItems.home, navItems.product);
    }

    // **Filter Kategori Produk**
    const categoryButtons = document.querySelectorAll('.category-menu button');
    const productItems = document.querySelectorAll('.product-item');

    categoryButtons.forEach(button => {
        button.addEventListener('click', () => {
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            const categoryId = button.getAttribute('data-category');
            productItems.forEach(item => {
                item.style.display = (categoryId === 'all' || item.getAttribute('data-category') === categoryId) ? 'block' : 'none';
            });
        });
    });

    // **Keranjang Belanja**
    const transactionList = document.querySelector('.product-list');
    const subtotalElement = document.querySelector('.list-subtotal .row2 h3:nth-child(2)');
    const chargeButton = document.querySelector('.charge');
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

                    // Aktifkan kembali tombol "Add to Cart"
                    const productItem = document.querySelector(`.product-item[data-name="${product.name}"]`);
                    if (productItem) {
                        const addToCartButton = productItem.querySelector('.add-to-cart button');
                        addToCartButton.disabled = false;

                        // Perbarui stok di atribut data
                        const stock = parseInt(productItem.getAttribute('data-stock')) + existingProduct.quantity;
                        productItem.setAttribute('data-stock', stock);
                        productItem.querySelector('h3').textContent = `Stock: ${stock}`;
                    }
                }
                updateCart();
            });

            productElement.querySelector('.plus').addEventListener('click', () => {
                if (product.stock > 0) {
                    product.quantity += 1;
                    product.stock -= 1;
                    updateCart();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Out of stock!',
                        text: `Stock for ${product.name} is out`,
                    });
                }
            });
        });

        const subtotal = cart.reduce((sum, product) => sum + (product.price * product.quantity), 0);
        subtotalElement.textContent = `Rp. ${subtotal.toLocaleString('id-ID')}`;

        // Update tombol Charge dengan total
        const chargeButton = document.querySelector('.charge');
        chargeButton.textContent = `Charge Rp. ${subtotal.toLocaleString('id-ID')}`;
    }

    function modifyQuantity(productName, delta) {
        const product = cart.find(p => p.name === productName);
        if (!product) return;

        if (delta > 0 && product.stock > 0) {
            product.quantity += delta;
            product.stock -= delta;
        } else if (delta < 0 && product.quantity > 0) {
            product.quantity += delta;
            product.stock -= delta;
        }

        if (product.quantity === 0) {
            cart = cart.filter(p => p.name !== productName);
        }

        // Update stok di tampilan
        const productItem = document.querySelector(`.product-item[data-name="${product.name}"]`);
        if (productItem) {
            const updatedStock = parseInt(productItem.getAttribute('data-stock')) + delta;
            productItem.setAttribute('data-stock', updatedStock);
            productItem.querySelector('h3').textContent = `Stock: ${updatedStock}`;
        }

        updateCart();
    }

    productItems.forEach(item => {
        const addToCartButton = item.querySelector('.add-to-cart button');
        addToCartButton.addEventListener('click', () => {
            const productName = item.getAttribute('data-name');
            const productPrice = parseFloat(item.getAttribute('data-price'));
            const productStock = parseInt(item.getAttribute('data-stock'));
            const productImage = item.getAttribute('data-image');

            const existingProduct = cart.find(product => product.name === productName);
            if (existingProduct) {
                if (existingProduct.quantity < productStock) {
                    existingProduct.quantity += 1;
                    existingProduct.stock -= 1;
                } else {
                    Swal.fire('Oops!', 'Stock limit reached.', 'warning');
                }
            } else if (productStock > 0) {
                cart.push({
                    name: productName,
                    price: productPrice,
                    stock: productStock - 1,
                    image: productImage,
                    quantity: 1
                });
            } else {
                Swal.fire('Oops!', 'Out of stock.', 'error');
            }

            item.setAttribute('data-stock', productStock - 1);
            item.querySelector('h3').textContent = `Stock: ${productStock - 1}`;
            addToCartButton.disabled = true;

            updateCart();
        });
    });

    // **Pencarian Produk**
    const searchInput = document.getElementById('search-input');
    searchInput.addEventListener('input', () => {
        const query = searchInput.value.toLowerCase();
        productItems.forEach(item => {
            const productName = item.querySelector('h1').textContent.toLowerCase();
            item.style.display = productName.includes(query) ? 'block' : 'none';
        });
    });

    // **Tombol Charge**
    const chargeForm = document.getElementById('charge-form');
    const cancelButton = chargeForm.querySelector('.cancel-button');

    chargeButton.addEventListener('click', () => {
        const formItemsContainer = chargeForm.querySelector('#order-details');
        formItemsContainer.innerHTML = '';

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
                </div>`;

            formItemsContainer.appendChild(productElement);
        });

        chargeForm.style.display = 'block';
    });

    cancelButton.addEventListener('click', () => {
        chargeForm.style.display = 'none';
    });

    // **Submit Transaksi**
    $('#submitTransaction').on('click', function (e) {
        e.preventDefault();

        const totalAmount = $('#total_amount').val();
        const totalPayment = $('#total_payment').val();
        const products = $('#charge-form input[name="products"]').val();

        if (!products || JSON.parse(products).length === 0) {
            Swal.fire('Oops!', 'No products selected for the transaction!', 'warning');
            return;
        }

        $.ajax({
            url: "{{ route('transaction.submit') }}",
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                products,
                total_amount: totalAmount,
                total_payment: totalPayment
            },
            success: function (response) {
                Swal.fire(
                    response.success ? 'Success!' : 'Error!',
                    response.success ? 'Transaction successful!' : response.message,
                    response.success ? 'success' : 'error'
                );
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                Swal.fire('Error!', 'Something went wrong, please try again.', 'error');
            }
        });
    });
});
