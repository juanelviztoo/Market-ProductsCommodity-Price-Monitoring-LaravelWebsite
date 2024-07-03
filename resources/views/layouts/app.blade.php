<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market Monitor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @vite([])
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ url('/home') }}">Market Monitor</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item {{ Request::routeIs('pasar.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pasar.index') }}">Pasar</a>
                </li>
                <li class="nav-item {{ Request::routeIs('kategori.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('kategori.index') }}">Kategori</a>
                </li>
                <li class="nav-item {{ Request::routeIs('komoditi.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('komoditi.index') }}">Komoditi</a>
                </li>
                <li class="nav-item {{ Request::routeIs('produk_komoditi.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('produk_komoditi.index') }}">Produk Komoditi</a>
                </li>
                <li class="nav-item {{ Request::routeIs('riwayat_harga_komoditi.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('riwayat_harga_komoditi.index') }}">Riwayat Harga Komoditi</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user"></i> Hello, {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="fa fa-cog"></i> Profile User
                        </a>
                        <a class="dropdown-item" href="#" onclick="confirmLogout(event)">
                            <i class="fa fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile.edit') }}">{{ __('Profile User') }}</a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</a>
                    </form>
                </li> -->
        </div>
    </nav>
    <div class="container mt-5">
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").alert('close');
            }, 3750);
        });

        function confirmLogout(event) {
            event.preventDefault();
            if (confirm('Are You Sure You Want to Logout?')) {
                document.getElementById('logout-form').submit();
            }
        }
    </script>
</body>
</html>