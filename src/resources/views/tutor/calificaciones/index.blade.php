@extends('layouts.user')

@section('content')
<div class="container">
    <h2 class="mb-4">Calificaciones</h2>

    <a href="{{ route('calificaciones.create') }}" class="btn btn-primary mb-3">Nueva Calificación</a>

    <table class="table table-striped table-hover">
        <thead class="table-light">
            <tr>
                <th>Alumno</th>
                <th>Asignatura</th>
                <th>Nota</th>
                <th>Fecha</th>
                <th colspan="2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($grades as $grade)
                @if (!$grade || !$grade->id)
                    <tr>
                        <td colspan="6" class="text-danger">Error: calificación sin ID detectada</td>
                    </tr>
                    @continue
                @endif

                <tr>
                    <td>{{ $grade->student->name ?? '—' }}</td>
                    <td>{{ $grade->subject->name ?? '—' }}</td>
                    <td>{{ $grade->grade }}</td>
                    <td>{{ $grade->date }}</td>
                    <td>
                        <a href="{{ route('calificaciones.edit', ['grade' => $grade->id]) }}" class="btn btn-sm btn-warning">Editar</a>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('calificaciones.destroy', ['grade' => $grade->id]) }}" onsubmit="return confirm('¿Estás seguro?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
