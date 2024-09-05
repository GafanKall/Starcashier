document.addEventListener('DOMContentLoaded', function () {
    const homeNav = document.getElementById('nav-home');
    const productItemNav = document.getElementById('nav-product-item');
    const categoryNav = document.getElementById('nav-category');
    // Fungsi untuk mengaktifkan dan menonaktifkan state
    function activateNav(activeNav, inactiveNav) {
        activeNav.classList.add('active');
        inactiveNav.classList.remove('active');
    }

    // Event listener untuk Home
    homeNav.addEventListener('click', function () {
        activateNav(homeNav, productItemNav, categoryNav);
    });

    // Event listener untuk Product Item
    productItemNav.addEventListener('click', function () {
        activateNav(productItemNav, homeNav, categoryNav);
    });

    categoryNav.addEventListener('click', function () {
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


document.addEventListener('DOMContentLoaded', function () {
    const productItems = document.querySelectorAll('.product-item');
    const transactionList = document.querySelector('.product-list');
    const subtotalElement = document.querySelector('.list-subtotal .row2 h3:nth-child(2)');
    let cart = [];

    // Loop melalui setiap product-item
    productItems.forEach(item => {
        const addToCartButton = item.querySelector('.add-to-cart button'); // Mengambil tombol Add To Cart

        // Tambahkan event listener hanya untuk tombol Add To Cart
        addToCartButton.addEventListener('click', function (e) {
            e.stopPropagation(); // Mencegah event bubbling
            const productName = item.getAttribute('data-name');
            const productPrice = parseFloat(item.getAttribute('data-price'));
            let productStock = parseInt(item.getAttribute('data-stock'));
            const productImage = item.getAttribute('data-image');

            // Cari produk yang sudah ada di cart
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
                    productStock -= 1;
                } else {
                    alert("Out of stock.");
                }
            }

            item.setAttribute('data-stock', productStock);
            item.querySelector('h3').textContent = `Stock: ${productStock}`;

            updateCart();
        });
    });

    // Fungsi untuk update cart
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
        });

        const subtotal = cart.reduce((sum, product) => sum + (product.price * product.quantity), 0);
        subtotalElement.textContent = `Rp. ${subtotal.toLocaleString('id-ID')}`;
    }
});


item.addEventListener('click', function () {
    const productId = item.getAttribute('data-id');
    const productName = item.getAttribute('data-name');
    const productPrice = parseFloat(item.getAttribute('data-price'));
    let productStock = parseInt(item.getAttribute('data-stock'));
    const productImage = item.getAttribute('data-image');

    if (productStock > 0) {
        fetch(`/product/decrease-stock/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {

                    productStock -= 1;
                    item.setAttribute('data-stock', productStock);
                    item.querySelector('h3').textContent = `Stock: ${productStock}`;

                    const existingProduct = cart.find(product => product.name === productName);
                    if (existingProduct) {
                        existingProduct.quantity += 1;
                    } else {
                        cart.push({
                            name: productName,
                            price: productPrice,
                            stock: productStock,
                            image: productImage,
                            quantity: 1
                        });
                    }

                    updateCart();
                } else {
                    alert(data.message || 'Error updating stock');
                }
            })
            .catch(error => console.error('Error:', error));
    } else {
        alert("Out of stock.");
    }
});

addToCartButton.addEventListener('click', function (e) {
    e.stopPropagation(); // Mencegah event bubbling
    const productId = item.getAttribute('data-id');
    const productName = item.getAttribute('data-name');
    const productPrice = parseFloat(item.getAttribute('data-price'));
    let productStock = parseInt(item.getAttribute('data-stock'));
    const productImage = item.getAttribute('data-image');

    if (productStock > 0) {
        fetch(`/product/decrease-stock/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update stok di interface setelah berhasil mengurangi di database
                    productStock = data.stock;
                    item.setAttribute('data-stock', productStock);
                    item.querySelector('h3').textContent = `Stock: ${productStock}`;

                    // Update cart
                    const existingProduct = cart.find(product => product.name === productName);
                    if (existingProduct) {
                        existingProduct.quantity += 1;
                    } else {
                        cart.push({
                            name: productName,
                            price: productPrice,
                            stock: productStock,
                            image: productImage,
                            quantity: 1
                        });
                    }

                    updateCart();
                } else {
                    alert(data.message || 'Error updating stock');
                }
            })
            .catch(error => console.error('Error:', error));
    } else {
        alert("Out of stock.");
    }
});


productElement.querySelector('.plus').addEventListener('click', function () {
    const productId = item.getAttribute('data-id');

    fetch(`/product/increase-stock/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                quantity: 1
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                productStock = data.stock;
                item.setAttribute('data-stock', productStock);
                item.querySelector('h3').textContent = `Stock: ${productStock}`;
                updateCart();
            } else {
                alert(data.message || 'Error updating stock');
            }
        })
        .catch(error => console.error('Error:', error));
});
