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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand navbar-brand-divider" href="{{ url('/home') }}">
            <i class="fas fa-chart-line"></i> Market Monitor
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                @auth
                <li class="nav-item {{ Request::routeIs('pasar.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pasar.index') }}">
                        <i class="fas fa-store"></i> Pasar
                    </a>
                </li>
                <li class="nav-item {{ Request::routeIs('kategori.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('kategori.index') }}">
                        <i class="fas fa-list-alt"></i> Kategori
                    </a>
                </li>
                <li class="nav-item {{ Request::routeIs('komoditi.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('komoditi.index') }}">
                        <i class="fas fa-box"></i> Komoditi
                    </a>
                </li>
                <li class="nav-item {{ Request::routeIs('produk_komoditi.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('produk_komoditi.index') }}">
                        <i class="fas fa-cubes"></i> Produk Komoditi
                    </a>
                </li>
                <li class="nav-item {{ Request::routeIs('riwayat_harga_komoditi.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('riwayat_harga_komoditi.index') }}">
                        <i class="fas fa-history"></i> Riwayat Harga Komoditi
                    </a>
                </li>
                @endauth
                <li class="nav-item {{ Request::routeIs('developer.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('developer.index') }}">
                        <i class="fas fa-user-cog"></i> Developer Profile
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    @auth
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user"></i> Hello, {{ ucfirst(Auth::user()->usertype) }} {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="fa fa-cog"></i> Setting Profile
                        </a>
                        <a class="dropdown-item" href="#" onclick="confirmLogout(event)">
                            <i class="fa fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="btn">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn">Register</a>
                    @endif
                    @endauth
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

    <div class="content">
        @yield('content1')
        <div class="container mt-4">
            @yield('content')
        </div>
    </div>

    <footer>
        <img src="storage/footer/bpn-logo.png" alt="Web Icon" class="icon-web">
        <div class="footer-content">
            <p>UNS Developer - Market Monitor &copy; 2024</p>
            <div class="social-icons">
                <a href="https://wa.me/+6282324772644" target="_blank"><i class="fab fa-whatsapp"></i></a>
                <a href="https://www.instagram.com/p/C8523HIyUg7/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://github.com/juanelviztoo/Market-ProductsCommodity-Price-Monitoring-LaravelWebsite.git" target="_blank"><i class="fab fa-github"></i></a>
            </div>
        </div>
        <img src="storage/footer/kosong.png" alt="Right Icon" class="icon-right">
    </footer>

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