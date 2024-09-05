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

    {{-- Bootstrap --}}

</head>

<body>

    {{-- Sidebar --}}
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

    {{-- Section --}}
    <section class="home">
        <div class="text">Petugas</div>

        <div class="button-create">
            <button id="show-form-btn">Add Petugas</button>
        </div>

        <div id="petugas-form" class="petugas-form">
            <form action="{{ route('petugas.store') }}" method="POST">
                @csrf
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Submit</button>
                <button type="button" id="close-form-btn">Cancel</button>
            </form>
        </div>

        <div id="edit-petugas-form" class="petugas-form">
            <form id="edit-form" action="{{ route('petugas.update', 0) }}" method="POST">
                @csrf
                @method('PUT')
                <label for="edit-email">Email:</label>
                <input type="email" id="edit-email" name="email" required>

                <label for="edit-username">Username:</label>
                <input type="text" id="edit-username" name="username" required>

                <label for="edit-password">Password:</label>
                <input type="password" id="edit-password" name="password">

                <button type="submit">Update</button>
                <button type="button" id="close-edit-form-btn">Cancel</button>
            </form>
        </div>


        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($petugas as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->email }}</td>
                        <td>{{ $p->username }}</td>
                        <td>
                            <div class="button-container">
                                <form action="{{ route('petugas.destroy', $p->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                </form>
                                <button class="edit-button" data-id="{{ $p->id }}">Edit</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </section>

    <script src="{{ asset('js/sidebarAdmin.js') }}"></script>

</body>

</html>
