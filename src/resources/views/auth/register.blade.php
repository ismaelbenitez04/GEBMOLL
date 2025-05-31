<x-guest-layout>
    <!-- Logo -->
    <div class="text-center mb-6">
        <img src="{{ asset('multimedia/gebmoll_logo.png') }}" alt="Logo GEBMOLL" class="w-60 mx-auto">
    </div>

    <!-- Registro -->
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Rol -->
        <div>
            <x-input-label for="role" :value="__('Rol')" />
            <select id="role" name="role" required class="w-full mt-1 rounded-md border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
                <option value="alumno">Alumno</option>
                <option value="docente">Docente</option>
                <option value="tutor">Tutor</option>
                <option value="admin">Administrador</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Nombre -->
        <div>
            <x-input-label for="name" :value="__('Nombre completo')" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus class="w-full mt-1" autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required class="w-full mt-1" autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Contraseña -->
        <div>
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" type="password" name="password" required class="w-full mt-1" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmar contraseña -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required class="w-full mt-1" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Enlace + botón -->
        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-blue-700 dark:hover:text-white underline">
                ¿Ya tienes cuenta?
            </a>
            <x-primary-button class="bg-blue-600 hover:bg-blue-700">
                Registrarse
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
