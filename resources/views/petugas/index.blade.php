<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('../images/LOGO.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">


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
                    <div class="product-item" data-id="{{ $product->id }}" data-name="{{ $product->product_name }}"
                        data-price="{{ $product->price }}" data-stock="{{ $product->stock }}"
                        data-image="{{ asset('storage/' . $product->image) }}"
                        data-category="{{ $product->categories_id }}">
                        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->product_name }}">
                        <h1>{{ $product->product_name }}</h1>
                        <p>Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                        <h3>Stock: {{ $product->stock }}</h3>
                        <div class="add-to-cart">
                            <button type="button">Add To Cart +</button>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

        <div id="charge-form" class="charge-form" style="display: none;">
            <form action="{{ route('transaction.submit') }}" method="POST" id="transaction-form"
                action="/submit-transaction">
                @csrf
                <input type="hidden" name="products" id="products" value='[]'>
                <input type="hidden" name="total_amount">
                <input type="hidden" name="total_payment">
                <div class="form-group">
                    <h3 for="order-details">Order Details:</h3>
                    <div id="order-details" class="detail-list">
                    </div>
                </div>
                <div class="charge-detail">
                    <div class="form-group">
                        <label for="total-amount">Total Price (Rp.):</label>
                        <input type="number" id="total-amount" name="total_amount" readonly>
                    </div>
                    <div class="form-group">
                        <label for="total-payment">Total Payment (Rp.):</label>
                        <input type="number" id="total-payment" name="total_payment">
                    </div>
                    <button type="submit" class="submit-button">Submit Order</button>
                    <button type="button" class="cancel-button" id="cancel-order">Cancel</button>
                </div>
            </form>
        </div>



        <div class="transaction">
            <h1>Order Menu</h1>
            <div class="product-list">
                {{-- <div class="list-order">
                    <div class="image-product">
                        <img src="{{ asset('images/P6.png') }}" alt="">
                    </div>
                    <div class="total">
                        <div class="total-product">
                            <h3>Coca Cola</h3>
                            <h3>(2)</h3>
                        </div>
                        <p>Rp. 35.000</p>
                    </div>
                    <div class="subtotal">
                        <p>Rp. 10.000</p>
                    </div>
                </div> --}}
                {{-- <div class="list-order">
                    <div class="image-product">
                        <img src="{{ asset('images/P5.png') }}" alt="">
                    </div>
                    <div class="total">
                        <div class="total-product">
                            <h3>Ice Cream Oreo</h3>
                            <h3>(2)</h3>
                        </div>
                        <p>Rp. 35.000</p>
                    </div>
                    <div class="subtotal">
                        <p>Rp. 70.000</p>
                    </div>
                </div>
                <div class="list-order">
                    <div class="image-product">
                        <img src="{{ asset('images/P5.png') }}" alt="">
                    </div>
                    <div class="total">
                        <div class="total-product">
                            <h3>Ice Cream Oreo</h3>
                            <h3>(2)</h3>
                        </div>
                        <p>Rp. 35.000</p>
                    </div>
                    <div class="subtotal">
                        <p>Rp. 70.000</p>
                    </div>
                </div>
                <div class="list-order">
                    <div class="image-product">
                        <img src="{{ asset('images/P5.png') }}" alt="">
                    </div>
                    <div class="total">
                        <div class="total-product">
                            <h3>Ice Cream Oreo</h3>
                            <h3>(2)</h3>
                        </div>
                        <p>Rp. 35.000</p>
                    </div>
                    <div class="subtotal">
                        <p>Rp. 70.000</p>
                    </div>
                </div> --}}
                <div>
                </div>
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
                <button class="charge">Charge Rp.</button>
            </div>
        </div>


    </section>
    <script src="{{ asset('js/petugas/petugasHome.js') }}"></script>
</body>

</html>
