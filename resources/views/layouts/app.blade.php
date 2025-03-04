<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TESTE BUDMOL')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <ul class="nav-links">
                @if(isset($token) && $token)
                    <div class="links">
                        <li><a href="{{ route('home', ['token' => $token]) }}">Eventos</a></li>
                        <li><a href="{{ route('dashboard', ['token' => $token]) }}">Painel</a></li>
                    </div>
                    <li><a class="logout" href="{{ route('logout', ['token' => $token]) }}"><i class="bi bi-box-arrow-left"></i></a></li>
                @endif
                </ul>
            </div>
        </nav>
    </header>

    <div class="container">
        @yield('content')
    </div>

    <footer>
        <p>&copy; 2025 TESTE BUDMOL - Todos os direitos reservados.</p>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
