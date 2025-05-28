<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            Tutorandos asignados
        </h2>
    </x-slot>

    <div class="py-6 px-4">
        @if ($tutorandos->isEmpty())
            <p>No tienes tutorandos asignados.</p>
        @else
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">Nombre</th>
                        <th class="border px-4 py-2">Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tutorandos as $alumno)
                        <tr>
                            <td class="border px-4 py-2">{{ $alumno->name }}</td>
                            <td class="border px-4 py-2">{{ $alumno->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
