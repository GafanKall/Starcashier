<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('../images/LOGO.png') }}">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="{{ asset('css/petugas/petugasProduct.css') }}">

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="{{ asset('images/LOGO.png') }}" alt="">
                </span>

                <div class="text logo-text">
                    <span class="name">Petugas</span>
                    <span class="profession">StarCashier</span>
                </div>
            </div>

        </header>

        <div class="menu-bar">
            <div class="menu">

                <ul class="menu-links">
                    <li id="nav-home" class="nav-link">
                        <a href="/petugas/home">
                            <i class='bx bx-home-alt icon'></i>
                            <span class="text nav-text">Home</span>
                        </a>
                    </li>

                    <li id="nav-product-item" class="nav-link">
                        <a href="/petugas/product">
                            <i class='bx bx-bar-chart-alt-2 icon'></i>
                            <span class="text nav-text">Product Item</span>
                        </a>
                    </li>

                    <li id="nav-category" class="nav-link">
                        <a href="/petugas/category">
                            <i class='bx bxs-category-alt icon'></i>
                            <span class="text nav-text">Category</span>
                        </a>
                    </li>

                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="#">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                style="background: none; border: none; color: inherit; cursor: pointer; padding: 0; font: inherit; display: flex; align-items: center; text-decoration: none;">
                                <i class='bx bx-log-out icon'></i>
                                <span class="text nav-text">Logout</span>
                            </button>
                        </form>
                    </a>
                </li>
            </div>

        </div>

    </nav>

    <section class="home">
        <div class="text">Product Item</div>

        <div class="button-create">
            <button id="show-form-btn">Add Product</button>
        </div>

        <div id="product-form" class="product-form">
            <h2>Add Product</h2>
            <form action="{{ route('petugas.product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="image">Image</label>
                <input type="file" id="image" name="image" required>

                <label for="product_name">Product Name</label>
                <input type="text" id="product_name" name="product_name" required>

                <label for="price">Price</label>
                <input type="number" id="price" name="price" required>

                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" required>

                <div class="inline-fields">
                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <option value="Burger">Burger</option>
                        <option value="Pizza">Pizza</option>
                        <option value="Ice Cream">Ice Cream</option>
                        <option value="Drink">Drink</option>
                        <option value="Other">Other</option>
                    </select>

                    <div class="button-form">
                        <button type="submit">Submit</button>
                        <button type="button" id="close-form-btn">Cancel</button>
                    </div>
                </div>
            </form>

        </div>

        <div id="edit-product-form" class="product-form" style="display:none;">
            <form id="edit-form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <label for="edit-image">Image</label>
                <input type="file" id="edit-image" name="image">
                <img id="edit-image-preview" src="" alt="" width="100">

                <label for="edit_product_name">Product Name</label>
                <input type="text" id="edit_product_name" name="product_name" required>

                <label for="edit_price">Price</label>
                <input type="number" id="edit_price" name="price" required>

                <label for="edit_stock">Stock</label>
                <input type="number" id="edit_stock" name="stock" required>

                <label for="edit_category">Category</label>
                <select id="edit_category" name="category" required>
                    <option value="Burger">Burger</option>
                    <option value="Pizza">Pizza</option>
                    <option value="Ice Cream">Ice Cream</option>
                    <option value="Drink">Drink</option>
                    <option value="Other">Other</option>
                </select>

                <button type="submit">Update</button>
                <button type="button" id="close-edit-form-btn">Cancel</button>
            </form>
        </div>

        <div class="table-container">
            <a href="{{ route('petugas.product.store') }}"></a>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Category</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img src="{{ Storage::url($product->image) }}" alt="{{ $product->product_name }}"
                                    width="50"></td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->category }}</td>
                            <td>
                                <form action="{{ route('petugas.product.destroy', $product->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-button"
                                        onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                </form>
                                <button class="show-form-btn"
                                    onclick="showEditForm(
                                        {{ $product->id }},
                                        '{{ $product->product_name }}',
                                        {{ $product->price }},
                                        {{ $product->stock }},
                                        '{{ $product->category }}',
                                        '{{ $product->image }}'
                                    )">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </section>

    <script src="{{ asset('js/petugas/petugasProduct.js') }}"></script>

</body>

</html>
