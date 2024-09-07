<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('../images/LOGO.png') }}">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="{{ asset('css/petugas/petugasCategory.css') }}">

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
        <div class="text">Category</div>

        <div class="button-create">
            <button id="show-form-btn">Add Category</button>
        </div>

        <div id="category-form" class="category-form">
            <h2>Add Product</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf

                <label for="category_name">Category Name</label>
                <input type="text" id="category_name" name="category_name" required>


                    <div class="button-form">
                        <button type="submit">Submit</button>
                        <button type="button" id="close-form-btn">Cancel</button>
                    </div>
                </div>
            </form>

        </div>

        <div id="edit-category-form" class="category-form" style="display:none;">
            <form id="edit-form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') 
                <label for="edit_category_name">Category Name</label>
                <input type="text" id="edit_category_name" name="category_name" required>

                <button type="submit">Update</button>
                <button type="button" id="close-edit-form-btn">Cancel</button>
            </form>
        </div>

        <div class="table-container">
            <a href="{{ route('petugas.category.store') }}"></a>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Category Name</th>
                        <th>-</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->category_name  }}</td>
                            <td>
                                <form action="{{ route('petugas.category.destroy', $category->id) }}" method="POST" style="display:inline;" >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-button"
                                        onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                </form>
                                <button class="show-form-btn" onclick="showEditForm('{{ $category->id }}', '{{ $category->category_name }}')">Edit</button>
                            </td>
                        </tr>
                        @endforeach
                </tbody>

            </table>
        </div>
    </section>

    <script src="{{ asset('js/petugas/petugasCategory.js') }}"></script>

</body>

</html>
