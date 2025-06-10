<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8f9fa;
        }

        .hero-text {
            color: #343a40;
        }

        .dark .hero-text {
            color: white;
        }

        .carousel-inner img {
            max-height: 400px;
            object-fit: contain;
        }

        .feature-card {
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .logo-img {
            width: 180px;
            height: auto;
        }

        .section-title {
            font-size: 1.8rem;
            margin-top: 2rem;
            font-weight: bold;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: invert(1);
        }
    </style>
</head>

<body class="antialiased">
    <div
        class="container-fluid min-vh-100 d-flex flex-column justify-content-center align-items-center text-center bg-light">
        <!-- Auth Links -->
        @if (Route::has('login'))
            <div class="position-absolute top-0 end-0 p-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary me-2">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Iniciar sesión</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">Registrarse</a>
                    @endif
                @endauth
            </div>
        @endif

        <!-- Logo & Description -->
        <img src="{{ asset('images/logo.png') }}" class="logo-img mb-4" alt="Logo">
        <h1 class="hero-text fw-bold">TCG Network</h1>
        <p class="hero-text fs-5 mb-5">Tu plataforma de gestión de tiendas y torneos de Trading Card Games</p>

        <!-- Carousel -->
        <div id="carouselExampleIndicators" class="carousel slide mb-5 w-75" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                    class="active"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('images/image1.png') }}" class="d-block w-100 mx-auto" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/image2.png') }}" class="d-block w-100 mx-auto" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/image3.png') }}" class="d-block w-100 mx-auto" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/image4.png') }}" class="d-block w-100 mx-auto" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>

        <!-- Feature Cards -->
        <h2 class="section-title">¿Cómo puedes usar TCG Network?</h2>
        <div class="row justify-content-center my-4 w-40 px-3">
            <div class="col-md-5 mb-4">
                <div class="card feature-card h-60 text-center">
                    <img src="{{ asset('images/tienda.png') }}" class="card-img-top p-3" alt="Tienda">
                    <div class="card-body">
                        <h4 class="card-title fw-bold">Siendo una tienda</h4>
                        <p class="card-text">¡Arma tus torneos de TCG y vende tus productos como un pro! Todo en un solo
                            lugar, fácil y rápido.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-5 mb-4">
                <div class="card feature-card h-60 text-center">
                    <img src="{{ asset('images/personas.png') }}" class="card-img-top p-3" alt="Usuario">
                    <div class="card-body">
                        <h4 class="card-title fw-bold">Siendo un usuario</h4>
                        <p class="card-text">¡Apúntate a torneos de tu TCG favorito y compra tus productos en tu tienda
                            de confianza!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>