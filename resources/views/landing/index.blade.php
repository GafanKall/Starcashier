<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>StarCashier</title>
    <link rel="icon" type="image/png" href="{{ asset('../images/LOGO.png') }}">

    {{-- My Css --}}
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">

</head>

<body>


    {{-- Section --}}
    <div class="section">

        {{-- Navbar --}}
        <nav>
            <div class="nav-logo">
                <img src="{{ '../images/LOGO.png' }}" alt="">
                <h1>Star</h1>
                <h1>Cashier</h1>
            </div>
            <div class="nav-button">
                <a href="{{ Route('login') }}" class="">
                    <button>Login</button>
                </a>
                <a href="{{ Route('register') }}" class="">
                    <button>Sign In</button>
                </a>
            </div>
        </nav>

        {{-- Main Section --}}
        <div class="main-section">
            <div class="section-text">
                <div class="main-text">
                    <h1>Welcome to Star</h1>
                    <h1>Cashier</h1>
                </div>
                <p>Designed to provide an efficient, user-friendly interface for managing your daily sales,
                    transactions, and inventory. Our system ensures accuracy, speed, and reliability, making it easier
                    than
                    ever to handle your business operations. Join us in revolutionizing the way you manage your
                    point-of-sale needs.</p>
                    <a href="/login">
                        <button class="btn-section">Buy Now</button>
                    </a>
            </div>
            <div class="section-image">
                <img src="{{ '../images/SBG1.png' }}" alt="">
            </div>
        </div>
    </div>

</body>

</html>
