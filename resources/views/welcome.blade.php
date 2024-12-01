<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Central</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background-image: url('{{ asset('img/bill-clave-de-gravity-falls_3840x2160_xtrafondos.com.jpg') }}');
            background-size: cover;
            background-position: center;
            height: 100vh;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        .hero-text h1 {
            font-size: 4rem;
            font-weight: bold;
            color: #ffffff;
            text-shadow: 0 0 5px #00ffcc, 0 0 10px #00ffcc, 0 0 20px #00ffff, 0 0 30px #00ffff, 0 0 40px #00ffcc, 0 0 50px #00ffcc;
        }
        .hero-text p {
            font-size: 1.5rem;
            color: #ffffff;
            text-shadow: 0 0 5px #ff66ff, 0 0 10px #ff66ff, 0 0 20px #ff99ff, 0 0 30px #ff99ff, 0 0 40px #ff66ff, 0 0 50px #ff66ff;
        }
        .btn-login {
            font-size: 1.2rem;
            padding: 10px 20px;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .btn-login:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-text text-center">
            <h1>Bienvenidos a la Biblioteca Central</h1>
            <p>Explora un mundo de conocimiento a través de nuestra colección de libros.</p>
            <a href="{{route('login')}}" class="btn-login mt-4">Iniciar Sesión</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
