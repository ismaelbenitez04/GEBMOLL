<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Calificaciones</h2>
    </x-slot>

    <div class="py-4">
        <a href="{{ route('calificaciones.create') }}" class="btn btn-primary mb-3">Nueva Calificación</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Alumno</th>
                    <th>Asignatura</th>
                    <th>Nota</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grades as $grade)
                    <tr>
                        <td>{{ $grade->student->name }}</td>
                        <td>{{ $grade->subject->name }}</td>
                        <td>{{ $grade->grade }}</td>
                        <td>{{ $grade->date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
