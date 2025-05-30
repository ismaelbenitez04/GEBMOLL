<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Admin Panel')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @stack('styles')
</head>
<body>
    <div class="d-flex vh-100">

        <!-- Sidebar -->
        <nav class="bg-dark text-white p-3" style="width: 220px;">
            <div class="mb-4 text-center">
                <img src="{{ asset('multimedia/gebmoll_logo.png') }}" alt="GEBMOLL Logo" style="width: 150px;">
            </div>

            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.inicio') }}" class="nav-link text-white {{ request()->routeIs('admin.inicio') ? 'active bg-primary' : '' }}">
                        Inicio
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.alumnos.index') }}" class="nav-link text-white {{ request()->routeIs('admin.alumnos.*') ? 'active bg-primary' : '' }}">
                        Alumnos
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.docentes.index') }}" class="nav-link text-white {{ request()->routeIs('admin.docentes.*') ? 'active bg-primary' : '' }}">
                        Docentes
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.tutores.index') }}" class="nav-link text-white {{ request()->routeIs('admin.tutores.*') ? 'active bg-primary' : '' }}">
                        Tutores
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.notas.index') }}" class="nav-link text-white {{ request()->routeIs('admin.notas.*') ? 'active bg-primary' : '' }}">
                        Notas
                    </a>
                </li>
                <li class="nav-item mb-2">
                      <a href="{{ route('admin.logs.index') }}" class="nav-link text-white {{ request()->routeIs('admin.logs.*') ? 'active bg-primary' : '' }}">
                        Logs
                    </a>
                </li>
            </ul>

            <hr class="border-secondary">
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
        <main class="flex-grow-1 p-4 bg-light overflow-auto">
            <h1 class="mb-4">@yield('title')</h1>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
