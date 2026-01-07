<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Welcome | MessageMe</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: radial-gradient(circle at top, #202c33, #0b141a);
            color: #e9edef;
        }

        .fade-up {
            animation: fadeUp 1.2s ease forwards;
            opacity: 0;
        }

        .fade-delay-1 { animation-delay: .3s; }
        .fade-delay-2 { animation-delay: .6s; }
        .fade-delay-3 { animation-delay: .9s; }

        @keyframes fadeUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .btn-main {
            background-color: #005c4b;
            border: none;
        }

        .btn-main:hover {
            background-color: #007a63;
        }

        .logo {
            width: 120px;
            height: auto;
        }
    </style>
</head>

<body class="vh-100 d-flex justify-content-center align-items-center">

<div class="text-center">

    <!-- LOGO -->
    <img src="{{ asset('images/logo_messageme.png') }}" class="img-fluid mb-4 fade-up fade-delay-1" style="max-width: 200px;" alt="MessageMe">

    <!-- TEXTO -->
    <h1 class="display-4 fw-bold fade-up fade-delay-2">
        Welcome!
    </h1>

    <p class="text-secondary mt-2 fade-up fade-delay-2">
        Simple chat. Fast. Safe.
    </p>

    <!-- BOTONES -->
    <div class="mt-4 d-flex justify-content-center gap-3 fade-up fade-delay-3">
        <a href="{{ route('login') }}" class="btn btn-main btn-lg px-4">
            Log in
        </a>

        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">
            Sign up
        </a>
    </div>

</div>

</body>
</html>
