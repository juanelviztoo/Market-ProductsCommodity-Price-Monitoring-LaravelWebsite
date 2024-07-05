<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');
        .body-carousel {
            margin: 0;
            overflow: hidden;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #000; /* Ensure a background color in case of image load failure */
        }

        .carousel-item {
            height: 100vh;
            background-size: cover;
            background-position: center;
        }

        .carousel-item img {
            width: 100%;
            height: 100vh;
            object-fit: cover;
            opacity: 0.5;
        }

        .content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            z-index: 2;
        }

        .content h1 {
            font-size: 7rem;
            margin-bottom: 20px;
            font-family: 'Montserrat', sans-serif;
        }

        .content .btn {
            padding: 10px 50px;
            font-size: 20px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            font-family: 'Montserrat', sans-serif;
        }

        .carousel-container {
            position: absolute;
            width: 100%;
            height: 100vh;
            top: 0;
            left: 0;
            z-index: 1;
        }
    </style>
</head>
<body class="body-carousel">
    <div class="carousel-container">
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel" data-interval="5000">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('storage/background/welcome-BG1.jpg') }}" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('storage/background/welcome-BG2.jpg') }}" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('storage/background/welcome-BG3.jpg') }}" alt="Third slide">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('storage/background/welcome-BG4.jpg') }}" alt="Fourth slide">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('storage/background/welcome-BG5.jpg') }}" alt="Fifth slide">
                </div>
            </div>
        </div>
    </div>
    
    <div class="content">
        <h1>Home Page</h1>
        <div class="button-container">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-custom">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-success btn-custom mr-2">Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-info btn-custom">Register</a>
                    @endif
                @endauth
            @endif
        </div>
        <div class="button-container mt-3">  
            @if (Route::has('login'))
            <a href="{{ url('/home') }}" class="btn btn-outline-warning btn-custom">Log In as Guest</a>
            @endif
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
