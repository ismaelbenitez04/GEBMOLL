@extends('layouts.user')

@section('title', 'Calificaciones')

@section('content')
<div class="container">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-semibold text-primary">Calificaciones</h1>
            <p class="text-muted mb-0">Lista de notas asignadas por materia y alumno.</p>
        </div>
        <a href="{{ route('calificaciones.create') }}" class="btn btn-outline-primary">+ Nueva Calificación</a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
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
                    @forelse ($grades as $grade)
                        @if (!$grade || !$grade->id)
                            <tr>
                                <td colspan="6" class="text-danger">⚠️ Error: calificación sin ID detectada</td>
                            </tr>
                            @continue
                        @endif

                        <tr>
                            <td>{{ $grade->student->name ?? '—' }}</td>
                            <td>{{ $grade->subject->name ?? '—' }}</td>
                            <td><strong>{{ $grade->grade }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($grade->date)->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('calificaciones.edit', ['grade' => $grade->id]) }}" class="btn btn-sm btn-outline-warning">Editar</a>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('calificaciones.destroy', ['grade' => $grade->id]) }}" onsubmit="return confirm('¿Estás seguro de eliminar esta calificación?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted text-center">No hay calificaciones registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
