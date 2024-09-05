<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>StarCashier</title>
    <link rel="icon" type="image/png" href="{{ asset('../images/LOGO.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- My Css --}}
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">

</head>

<body>
    <div class="form">
        <div class="form-section">

            {{-- Sign in Form --}}
            <form action="{{ route('register.store') }}" method="POST">

                @csrf

                <div class="main-form">
                    <h1 class="title">Sign In</h1>


                    <div class="form-input">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <label for="email">
                            <i class="bi bi-envelope"></i>
                        </label>
                    </div>


                    <div class="form-input">
                        <input type="text" name="username" class="form-control" placeholder="Username">
                        <label for="email">
                            <i class="bi bi-envelope"></i>
                        </label>
                    </div>


                    <div class="form-input">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <label for="password">
                            <i class="bi bi-lock-fill"></i>
                        </label>
                    </div>


                    <div class="main-content">
                        <div class="remember">
                            <input type="checkbox">
                            <label for="">Remember Me</label>
                        </div>
                        <div class="forgot">
                            <a href="">Forgot Password</a>
                        </div>
                    </div>
                    <div class="btn">
                        <button type="submit">Create an Account</button>
                        <div class="sign">
                            <h6>Already have an account?</h6>
                            <a href="/login">Login!</a>
                        </div>
                    </div>
                </div>
            </form>
            <div class="image-section">
                <img src="{{ asset('../images/BG4.png') }}" alt="">
            </div>
        </div>
    </div>
</body>

</html>
