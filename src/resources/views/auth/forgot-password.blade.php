<x-guest-layout>
    <!-- Logo opcional -->
    <div class="text-center mb-6">
        <img src="{{ asset('multimedia/gebmoll_logo.png') }}" alt="Logo GEBMOLL" class="w-60 mx-auto">
    </div>

    <!-- Instrucciones -->
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400 text-center leading-relaxed">
        ¿Olvidaste tu contraseña? No hay problema.<br>
        Ingresa tu dirección de correo electrónico y te enviaremos un enlace para restablecerla.
    </div>

    <!-- Estado de sesión -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Formulario -->
    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="'Correo electrónico'" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Botón -->
        <div class="flex justify-end">
            <x-primary-button class="bg-blue-600 hover:bg-blue-700">
                Enviar enlace de recuperación
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
