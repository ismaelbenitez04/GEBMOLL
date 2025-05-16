<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            
        @endif
    </head>
   <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex flex-col items-center justify-center min-h-screen p-6 lg:p-8">
         
        <main class="max-w-md text-center bg-white dark:bg-[#161615] p-10 rounded-lg shadow-lg">
            <div style="text-align:center;">
                <img src="{{ asset('multimedia/gebmoll_logo.png') }}" alt="Logo GEBMOLL" style="width: 250px;display: block; margin: 0 auto;">
            </div>
            
            <p class="text-gray-700 dark:text-[#A1A09A] mb-6 leading-relaxed">
               Aplicación para la Gestión Educativa de las Islas Baleares
            </p>
            
            <p class="text-sm text-gray-500 dark:text-[#706f6c]">
                Inicia sesión o registrate. 
            </p>
            <br>
            <div class="w-full max-w-md mb-10 text-center">
                @if (Route::has('login'))
                    <nav class="flex justify-center gap-6">
                        @auth
                            <a href="{{ url('/dashboard') }}" 
                            class="px-6 py-3 bg-[#0d6efd] text-white rounded-md shadow hover:bg-[#0000FF] transition">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                            class="px-6 py-3 bg-[#0d6efd] text-white rounded-md shadow hover:bg-[#0d6efd] transition">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" 
                                class="px-6 py-3 border border-[#0d6efd] text-[#0d6efd] rounded-md shadow hover:bg-[#0d6efd] hover:text-white transition">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </main>

    </body>

</html>
