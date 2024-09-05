<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" href="{{ asset('../images/LOGO.png') }}">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

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
                    <span class="name">Admin</span>
                    <span class="profession">StarCashier</span>
                </div>
            </div>

        </header>

        <div class="menu-bar">
            <div class="menu">

                <ul class="menu-links">

                    <li id="nav-home" class="nav-link">
                        <a href="/admin/home">
                            <i class='bx bx-home-alt icon'></i>
                            <span class="text nav-text">Home</span>
                        </a>
                    </li>

                    <li id="nav-product-item" class="nav-link">
                        <a href="/admin/petugas">
                            <i class='bx bxs-id-card icon'></i>
                            <span class="text nav-text">Employe</span>
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
        <div class="text">Dashboard Admin</div>

        {{-- Card --}}
        <div class="total-card">
            <div class="total-user">
                <h2>Total User</h2>
                <p>{{ $users->count() }}</p>
            </div>

            <div class="total-product">
                <h2>Total Product</h2>
                <p>{{ $products->count() }}</p>
            </div>
        </div>

        <div class="table">

            <table class="user">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->role }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="product">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td><img src="{{ Storage::url($product->image) }}" alt="{{ $product->product_name }}" style="width: 50px; height: auto;"></td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->stock }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <script src="{{ asset('js/sidebarAdmin.js') }}"></script>

</body>

</html>
