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

    @stack('styles')
</head>

<body>
    <div class="d-flex vh-100">
        <aside class="bg-light p-3 d-flex flex-column" style="width: 220px;">        
        <div style="text-align:center;">
            <img src="{{ asset('multimedia/gebmoll_logo.png') }}" alt="Logo GEBMOLL" style="width: 175px;display: block;">
        </div>

        @php
            $role = auth()->check() ? auth()->user()->role : '';
        @endphp
      

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
                    @elseif ($role === 'tutor')
                        <a href="{{ route('tutor.calendario') }}" class="nav-link {{ request()->routeIs('tutor.calendario') ? 'active' : '' }}">Calendario</a>
                    @else
                        <a href="{{ route('calendario.index') }}" class="nav-link {{ request()->routeIs('calendario.index') ? 'active' : '' }}">Calendario</a>
                    @endif
                </li>
                 {{-- Mostrar "Asistencia" diferente para alumnos --}}
                @if ($role === 'alumno')
                     <li class="nav-item">
                        <a href="{{ route('alumno.asistencia') }}" class="nav-link {{ request()->routeIs('alumno.asistencia') ? 'active' : '' }}">Asistencia</a>
                    </li>
                @elseif ($role === 'tutor')  
                     <li class="nav-item">
                        <a href="{{ route('tutor.asistencia') }}" class="nav-link {{ request()->routeIs('tutor.asistencia') ? 'active' : '' }}">
                            Asistencia
                        </a>
                    </li>
                @else
                   <li class="nav-item">
                        <a href="{{ url("/$role/asistencia") }}" class="nav-link {{ request()->is("$role/asistencia") ? 'active' : '' }}">Asistencia</a>
                    </li>
                @endif
               
                <li class="nav-item">
                    <a href="{{ route('mensajes.index') }}" class="nav-link {{ request()->routeIs('mensajes.*') ? 'active' : '' }}">Chats</a>
                </li>

                {{-- Mostrar "Calificaciones" diferente para alumnos --}}
                @if ($role === 'alumno')
                    <li class="nav-item">
                        <a href="{{ url("/alumno/calificaciones") }}" class="nav-link {{ request()->is('alumno/calificaciones') ? 'active' : '' }}">Calificaciones</a>
                    </li>
                @elseif ($role === 'tutor')  
                     <li class="nav-item">
                        <a href="{{ route('tutor.calificaciones.index') }}" class="nav-link {{ request()->routeIs('calificaciones.*') ? 'active' : '' }}">
                            Calificaciones
                        </a>
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
        <div class="mt-auto">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <x-dropdown-link :href="route('profile.edit')" class="nav-link">
                        {{ __('Perfil') }}
                    </x-dropdown-link>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" class="nav-link text-danger"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Cerrar sesión') }}
                        </x-dropdown-link>
                    </form>
                </li>
            </ul>
        </div>

    </aside>
    <main class="flex-grow-1 p-4">
        @yield('content')
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
@stack('scripts') 

</body>
</html>
