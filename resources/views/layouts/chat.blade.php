<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title') | MessageMe</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #0b141a;
        color: #e9edef;
    }

    .chat-sidebar {
        background-color: #111b21;
    }

    .chat-item {
        cursor: pointer;
        background-color: transparent;
        color: #e9edef;
        border: none;
    }

    .chat-item:hover {
        background-color: #202c33;
    }

    .chat-item.active {
        background-color: #2a3942 !important;
    }

    .chat-area {
        background-color: #0b141a;
    }

    .message-received {
        background-color: #202c33;
    }

    .message-sent {
        background-color: #005c4b;
    }

    .message-input {
        background-color: #202c33;
        border: none;
        color: #e9edef;
    }

    .message-input::placeholder {
        color: #8696a0;
    }
    </style>
</head>

<body class="vh-100 overflow-hidden">

    <nav class="navbar navbar-dark px-3" style="background:#202c33;">
        <span class="navbar-brand">MessageMe</span>

        <div class="dropdown">
            <a class="text-white dropdown-toggle text-decoration-none" href="#" data-bs-toggle="dropdown">
                {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <input type="file" name="profile_photo" class="form-control" value="Cambiar foto">
                        </div>

                        <button class="btn btn-success">Guardar</button>
                    </form>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item">Cerrar sesión</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>