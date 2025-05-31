<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GEBMOLL - Gestión Educativa</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-[#fdfdfc] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-white flex items-center justify-center min-h-screen p-6">

    <main class="w-full max-w-md bg-white dark:bg-[#161615] p-10 rounded-xl shadow-lg text-center">
        <img src="{{ asset('multimedia/gebmoll_logo.png') }}" alt="Logo GEBMOLL" class="w-56 mx-auto mb-6">

        <p class="text-gray-700 dark:text-[#A1A09A] mb-4 leading-relaxed">
            Aplicación para la Gestión Educativa de las Islas Baleares
        </p>

        <p class="text-sm text-gray-500 dark:text-[#706f6c] mb-6">
            Inicia sesión o regístrate para acceder a tu cuenta.
        </p>

        @if (Route::has('login'))
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="px-6 py-3 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 transition">
                        Ir al Panel
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-6 py-3 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 transition">
                        Iniciar Sesión
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-6 py-3 border border-blue-600 text-blue-600 rounded-md shadow hover:bg-blue-600 hover:text-white transition">
                            Registrarse
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </main>

</body>
</html>
