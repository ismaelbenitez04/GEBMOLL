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
        <div style="text-align:center;">
            <img src="{{ asset('multimedia/gebmoll_logo.png') }}" alt="Logo GEBMOLL" style="width: 175px;display: block;">
        </div>

        @php
            $role = auth()->check() ? auth()->user()->role : '';
        @endphp

        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ url("/$role/inicio") }}" class="nav-link {{ request()->is("$role/inicio") ? 'active' : '' }}">Inicio</a>
            </li>
            <li class="nav-item">
                <a href="{{ url("/$role/calendario") }}" class="nav-link {{ request()->is("$role/calendario") ? 'active' : '' }}">Calendario</a>
            </li>
            <li class="nav-item">
                <a href="{{ url("/$role/asistencia") }}" class="nav-link {{ request()->is("$role/asistencia") ? 'active' : '' }}">Asistencia</a>
            </li>
            <li class="nav-item">
                <a href="{{ url("/$role/chats") }}" class="nav-link {{ request()->is("$role/chats") ? 'active' : '' }}">Chats</a>
            </li>
            <li class="nav-item">
                <a href="{{ url("/$role/calificaciones") }}" class="nav-link {{ request()->is("$role/calificaciones") ? 'active' : '' }}">Calificaciones</a>
            </li>
            <li class="nav-item">
                <a href="{{ url("/$role/amonestaciones") }}" class="nav-link {{ request()->is("$role/amonestaciones") ? 'active' : '' }}">Amonestaciones</a>
            </li>
            <li class="nav-item">
                <a href="{{ url("/$role/tareas") }}" class="nav-link {{ request()->is("$role/tareas") ? 'active' : '' }}">Tareas</a>
            </li>
        </ul>
    </aside>
    <main class="flex-grow-1 p-4">
        <h2>¡Bienvenido, {{ auth()->user()->name }}!</h2>
        @yield('content')
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
