<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'WSBNLU Klub')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="min-vh-100 d-flex flex-column">
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">WSBNLU Klub</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false" aria-label="Przełącz menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Strona główna</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('members.index') }}">Członkowie</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('weapon-types.index') }}">Typy broni</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('weapons.index') }}">Broń</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('events.index') }}">Wydarzenia</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('fees.index') }}">Składki</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4 flex-grow-1">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-light border-top text-muted py-3 mt-auto">
        <div class="container small">
            Projekt: Programowanie zaawansowanych serwisów internetowych | Student: Wojciech Gosiewski | Prowadząca: Jolanta Klima-Gnojnicka
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
