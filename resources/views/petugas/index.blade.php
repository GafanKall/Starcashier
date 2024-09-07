<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('../images/LOGO.png') }}">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="{{ asset('css/petugas/petugasHome.css') }}">

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
                            <i class='bx bxs-notepad icon'></i>
                            <span class="text nav-text">Transaction</span>
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
        <div class="menu-content">
            <div class="header">
                <div class="text">Menu Category</div>
                <div class="search-bar">
                    <input type="text" placeholder="Search.." id="search-input">
                    <button type="button" id="search-button">
                        <i class='bx bx-search-alt-2'></i>
                    </button>
                </div>
            </div>

            {{-- Category Menu Button --}}
            <div class="category">
                <div class="category-menu">
                    <button class="default-button" data-category="all">All</button>
                    @foreach ($categories as $category)
                        <button data-category="{{ $category->id }}">{{ $category->category_name }}</button>
                    @endforeach
                </div>
            </div>

            <div class="text">Choose Order</div>
            <div class="product">
                @foreach ($products as $product)
                    <div class="product-item" data-name="{{ $product->product_name }}"
                        data-price="{{ $product->price }}" data-stock="{{ $product->stock }}"
                        data-image="{{ Storage::url($product->image) }}"
                        data-category="{{ $product->categories_id }}">
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->product_name }}">
                        <h1>{{ $product->product_name }}</h1>
                        <p>Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                        <h3>Stock: {{ $product->stock }}</h3>
                        <div class="add-to-cart">
                            <button>Add To Cart +</button>
                        </div>
                    </div>
                @endforeach
            </div>


        </div>
        <div class="transaction">
            <h1>Order Menu</h1>
            <div class="product-list">
            </div>
            <div class="list-subtotal">
                <div class="confirm-subtotal">
                    <div class="line"></div>
                    <div class="price">
                        <div class="row1">
                            <h3>Subtotal</h3>
                        </div>
                        <div class="row2">
                            <h3> Item</h3>
                            <h3>Rp. </h3>
                        </div>
                    </div>
                </div>
            </div>
            <button class="charge">Charge Rp.</button>
        </div>
    </section>
    <script src="{{ asset('js/petugas/petugasHome.js') }}"></script>

</body>

</html>
