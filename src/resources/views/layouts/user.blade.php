<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'GEBMOLL')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="d-flex vh-100">
    <aside class="bg-light p-3" style="width: 220px;">
        <h5>Menú</h5>
        <ul class="nav flex-column">
    <li class="nav-item">
        <a href="{{ url('/inicio') }}" class="nav-link {{ request()->is('inicio') ? 'active' : '' }}">
            Inicio
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('/calendario') }}" class="nav-link {{ request()->is('calendario') ? 'active' : '' }}">
            Calendario
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('/asistencia') }}" class="nav-link {{ request()->is('asistencia') ? 'active' : '' }}">
            Asistencia
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('/chats') }}" class="nav-link {{ request()->is('chats') ? 'active' : '' }}">
            Chats
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('/calificaciones') }}" class="nav-link {{ request()->is('calificaciones') ? 'active' : '' }}">
            Calificaciones
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('/amonestaciones') }}" class="nav-link {{ request()->is('amonestaciones') ? 'active' : '' }}">
            Amonestaciones
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('/tareas') }}" class="nav-link {{ request()->is('tareas') ? 'active' : '' }}">
            Tareas
        </a>
    </li>
</ul>

    </aside>
    <main class="flex-grow-1 p-4">
        <h2>Bienvenido, {{ auth()->user()->name }}</h2>
        @yield('content')
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
