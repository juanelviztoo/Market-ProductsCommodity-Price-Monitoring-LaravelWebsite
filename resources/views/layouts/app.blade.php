<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market Monitor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!--<link href="{{ asset('public/css/style.css') }}" rel="stylesheet">-->
    @vite([])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

        body {
            background-color: whitesmoke;
            background-image: url('/storage/background/HD-background13.jpg');
            background-size: cover;
            /* background-repeat: no-repeat; */
            background-attachment: fixed;
            background-position: center;
        }

        .container {
            max-width: 1350px; /* Atur lebar maksimum container */
            margin: auto; /* Pusatkan container di tengah halaman */
        }

        /* Style untuk container form */
        .container-form {
            background-color: whitesmoke; /* Warna background untuk form */
            background-image: url('/storage/background/WhitePlainBG2.jpg');
            border-radius: 8px; /* Radius sudut untuk form */
            padding: 25px; /* Padding di dalam form */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Style shadow untuk form */
            max-width: 950px; /* Lebar maksimum form */
            margin-top: 20px; /* Membuat form berada di tengah secara vertikal */
            margin-bottom: 40px;
        }

        /* Style untuk container pasar */
        .container-pasar {
            position: sticky;
            top: 0%;
            margin-bottom: 35px;
            transform: translateY(-50%);
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            align-items: center;
        }

        /* Style untuk container kategori */
        .container-kategori {
            position: sticky;
            margin-top: 60px;
            top: 12%;
            transform: translateY(-50%);
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            align-items: center;
        }

        /* Style untuk container komoditi */
        .container-komoditi {
            position: sticky;
            margin-top: 50px;
            top: 12%;
            transform: translateY(-50%);
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            align-items: center;
        }

        /* Style untuk container produk  */
        .container-produk {
            position: sticky;
            margin-bottom: 30px;
            top: 10%;
            transform: translateY(-50%);
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            align-items: center;
        }

        /* Style untuk container riwayat harga komoditi  */
        .container-riwayat {
            position: sticky;
            margin-bottom: 30px;
            top: 10%;
            transform: translateY(-50%);
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            align-items: center;
        }

        .developer-container {
            margin-top: 30px;
        }

        .developer-card {
            background-color: #f9f9f9;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
        }

        .profile-photo {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        .developer-card .card-body {
            padding: 0 1.5rem;
        }

        .developer-card h5 {
            margin-bottom: 0.5rem;
        }

        .jumbotron{
            background-image: url('/storage/background/WhitePlainBG2.jpg');
            opacity: 0.9;
            /* background-blend-mode: color-burn; */
            background-size: cover;
            border-radius: 115px;
        }

        .h2-home{
            text-decoration: overline;
            margin-bottom: 20px;
        }

        .card-komoditi {
            margin-bottom: 20px;
            background-image: url('/storage/background/WhitePlainBG2.jpg');
        }

        /* Style untuk efek hover pada gambar */
        .card-img-top {
            transition: transform 0.3s ease;
        }

        .card-img-top:hover {
            transform: scale(1.2);
        }

        .badge {
            display: inline-block;
            padding: .35em .65em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem;
        }

        .text-success {
            color: #28a745 !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .text-warning {
            color: #ffc107 !important;
        }

        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');

        .parallax-content {
            padding: 300px 0;
            text-align: center;
            color: #fff;
            position: relative;
            z-index: 2;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            font-family: 'Montserrat', sans-serif;
        }

        .parallax-content h1 {
            font-size: 4rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .parallax-content h5 {
            font-size: 1.5rem;
            font-weight: normal;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        header {
            position: relative;
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            height: 100vh;
        }

        .after-parallax {
            margin-top: 5vh;
        }

        .main-title {
            text-align: left;
            margin-bottom: 30px;
            font-family: 'Montserrat', sans-serif;
            font-weight: bold;
            font-size: 2rem;
        }

        .kategori-card {
            margin-bottom: 30px;
            background-color: rgba(255, 255, 255, 0.8);
        }

        .card-komoditi {
            height: 100%;
        }

        .card-komoditi img {
            width: 100%;
            height: 200px;
            object-fit: contain;
        }

        .card-title-kategori {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            font-family: 'Montserrat', sans-serif;
        }

        .empty-card {
            margin-top: 30px;
            padding: 20px;
            border: 1px solid #ddd;
        }

        .shadow {
            box-shadow: 0 0 10px rgba(0,0,0,0.1); /* Contoh bayangan ringan */
            transition: box-shadow 0.3s ease; /* Efek transisi jika diinginkan */
        }

        .radius {
            border-radius: 10px;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content {
            flex: 1;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            display: grid;
            grid-template-columns: auto 1fr auto; /* Menggunakan kolom ke-3 untuk gambar kanan */
            align-items: center;
            text-align: center;
        }

        footer .icon-web {
            grid-column: 1;
            margin-left: 20px;
            width: 100px; /* Sesuaikan ukuran sesuai kebutuhan */
            height: auto;
        }

        footer .footer-content {
            grid-column: 2;
        }

        footer .social-icons {
            margin: 10px 0;
        }

        footer .social-icons a {
            color: #fff;
            margin: 0 15px;
            font-size: 30px;
            transition: color 0.3s ease;
        }

        footer .social-icons a:hover {
            color: #d4d4d4;
        }

        footer .icon-right {
            grid-column: 3; /* Atur agar gambar di sebelah kanan */
            margin-right: 20px;
            width: 100px; /* Sesuaikan ukuran sesuai kebutuhan */
            height: auto;
        }

        .navbar-brand-divider {
            border-right: 1px solid #ccc;
            padding-right: 20px;
            margin-right: 20px;
        }

        .navbar-nav .nav-item {
            margin-right: 5px; /* Jarak spasi di antara setiap menu navbar */
        }



        .card-komoditi .card-front,
        .card-komoditi .card-back {
            transition: transform 0.6s;
            transform-style: preserve-3d;
            backface-visibility: hidden;
        }
        .card-komoditi.flipped .card-front {
            transform: rotateY(180deg);
        }
        .card-komoditi.flipped .card-back {
            transform: rotateY(0);
        }
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
                <li class="nav-item">
                    <a class="nav-link" href="https://t.me/Monitor_Komoditi_Bot" target="_blank">
                        <i class="fab fa-telegram-plane"></i> Telegram Bot Chat
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
        <img src="storage/footer/logo-uns.png" alt="Web Icon" class="icon-web">
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