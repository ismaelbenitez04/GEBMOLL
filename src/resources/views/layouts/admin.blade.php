<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Panel Administrativo')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Fuente moderna -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8FAFC;
        }

        nav {
            background-color: #0F172A;
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
            background-color: #3B82F6 !important;
            color: white !important;
        }

        .nav-link.text-danger:hover {
            background-color: #DC2626;
            color: white !important;
        }

        main {
            background-color: #F1F5F9;
        }

        hr {
            border-color: #475569;
        }
    </style>

    @stack('styles')
</head>
<body>
<div class="d-flex vh-100">
    <!-- Sidebar -->
    <nav class="d-flex flex-column text-white p-4" style="width: 250px;">
        <div class="text-center mb-4">
            <img src="{{ asset('multimedia/gebmoll_logo.png') }}" alt="GEBMOLL Logo" style="width: 160px;">
        </div>

        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a href="{{ route('admin.inicio') }}" class="nav-link {{ request()->routeIs('admin.inicio') ? 'active' : '' }}">
                    Inicio
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.alumnos.index') }}" class="nav-link {{ request()->routeIs('admin.alumnos.*') ? 'active' : '' }}">
                    Alumnos
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.docentes.index') }}" class="nav-link {{ request()->routeIs('admin.docentes.*') ? 'active' : '' }}">
                    Docentes
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.tutores.index') }}" class="nav-link {{ request()->routeIs('admin.tutores.*') ? 'active' : '' }}">
                    Tutores
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.notas.index') }}" class="nav-link {{ request()->routeIs('admin.notas.*') ? 'active' : '' }}">
                    Notas
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.logs.index') }}" class="nav-link {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}">
                    Logs
                </a>
            </li>
        </ul>

        <hr class="my-4">

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
    </nav>

    <!-- Main content -->
    <main class="flex-grow-1 p-4 overflow-auto">
        <div class="container-fluid">
            <h1 class="mb-4 fw-semibold text-primary">@yield('title')</h1>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @yield('content')
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
