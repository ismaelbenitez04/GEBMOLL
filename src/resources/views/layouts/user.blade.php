<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'GEBMOLL')</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- FullCalendar CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">

    {{-- Fuente moderna --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8FAFC;
        }

        aside {
            background-color: #1E293B;
            color: #FFFFFF;
        }

        .nav-link {
            color: #CBD5E1;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
        }

        .nav-link:hover {
            background-color: #334155;
            color: white;
        }

        .nav-link.active {
            background-color: #3B82F6;
            color: white !important;
        }

        .sidebar-footer .nav-link {
            color: #F87171;
        }

        main {
            background-color: #F1F5F9;
        }
    </style>

    @stack('styles')
</head>

<body>
<div class="d-flex vh-100">
    {{-- SIDEBAR --}}
    <aside class="d-flex flex-column p-4" style="width: 250px;">
        <div class="text-center mb-4">
            <img src="{{ asset('multimedia/gebmoll_logo.png') }}" alt="Logo GEBMOLL" style="width: 170px;">
        </div>

        @php
            $role = auth()->check() ? auth()->user()->role : '';
        @endphp

        {{-- NAVEGACIÓN --}}
        <div>
            <ul class="nav flex-column">
                @if ($role === 'tutor')
                    <li class="nav-item">
                        <a href="{{ route('tutor.inicio') }}" class="nav-link {{ request()->routeIs('tutor.inicio') ? 'active' : '' }}">Inicio</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ url("/$role/inicio") }}" class="nav-link {{ request()->is("$role/inicio") ? 'active' : '' }}">Inicio</a>
                    </li>
                @endif

                <li class="nav-item">
                    
                    @if ($role === 'alumno')
                        <a href="{{ route('alumno.calendario') }}" class="nav-link {{ request()->routeIs('alumno.calendario') ? 'active' : '' }}">Calendario</a>
                    @elseif ($role == 'tutor')
                        <a href="{{ route('tutor.calendario.index') }}" class="nav-link {{ request()->routeIs('tutor.calendario') ? 'active' : '' }}">Calendario</a>
                    @else
                        <a href="{{ route('calendario.index') }}" class="nav-link {{ request()->routeIs('calendario.index') ? 'active' : '' }}">Calendario</a>
                    @endif
                </li>

                @if ($role === 'alumno')
                    <li class="nav-item">
                        <a href="{{ route('alumno.asistencia') }}" class="nav-link {{ request()->routeIs('alumno.asistencia') ? 'active' : '' }}">Asistencia</a>
                    </li>
                @elseif ($role === 'tutor')  
                    <li class="nav-item">
                        <a href="{{ route('tutor.asistencia') }}" class="nav-link {{ request()->routeIs('tutor.asistencia') ? 'active' : '' }}">Asistencia</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ url("/$role/asistencia") }}" class="nav-link {{ request()->is("$role/asistencia") ? 'active' : '' }}">Asistencia</a>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('mensajes.index') }}" class="nav-link {{ request()->routeIs('mensajes.*') ? 'active' : '' }}">Chats</a>
                </li>

                @if ($role === 'alumno')
                    <li class="nav-item">
                        <a href="{{ url("/alumno/calificaciones") }}" class="nav-link {{ request()->is('alumno/calificaciones') ? 'active' : '' }}">Calificaciones</a>
                    </li>
                @elseif ($role === 'tutor')  
                    <li class="nav-item">
                        <a href="{{ route('tutor.calificaciones.index') }}" class="nav-link {{ request()->routeIs('calificaciones.*') ? 'active' : '' }}">Calificaciones</a>
                    </li> 
                @else
                    <li class="nav-item">
                        <a href="{{ route('calificaciones.index') }}" class="nav-link {{ request()->routeIs('calificaciones.*') ? 'active' : '' }}">Calificaciones</a>
                    </li>
                @endif

                @if($role === 'tutor')
                    <li class="nav-item">
                        <a href="{{ route('tutor.tareas.index') }}" class="nav-link {{ request()->routeIs('tutor.tareas.*') ? 'active' : '' }}">Tareas</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ url("/$role/tareas") }}" class="nav-link {{ request()->is("$role/tareas") ? 'active' : '' }}">Tareas</a>
                    </li>
                @endif
            </ul>
        </div>

        {{-- PERFIL Y CERRAR SESIÓN --}}
        <div class="mt-auto sidebar-footer">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <x-dropdown-link :href="route('profile.edit')" class="nav-link">
                        {{ __('Perfil') }}
                    </x-dropdown-link>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" class="nav-link"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Cerrar sesión') }}
                        </x-dropdown-link>
                    </form>
                </li>
            </ul>
        </div>
    </aside>

    {{-- CONTENIDO PRINCIPAL --}}
    <main class="flex-grow-1 p-4">
        <div class="container-fluid">
            @yield('content')
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
@stack('scripts') 
</body>
</html>
