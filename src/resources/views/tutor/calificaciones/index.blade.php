@extends('layouts.user')

@section('title', 'Calificaciones')

@section('content')
<div class="container">
    <h2 class="mb-4 text-primary fw-semibold">Gestión de Calificaciones</h2>

    <a href="{{ route('tutor.calificaciones.create') }}" class="btn btn-success mb-4">
        ➕ Nueva Calificación
    </a>

    @if ($grades->isEmpty())
        <div class="alert alert-info">No hay calificaciones registradas.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle rounded shadow-sm">
                <thead class="table-light">
                    <tr>
                        <th>👤 Alumno</th>
                        <th>📚 Asignatura</th>
                        <th>📈 Nota</th>
                        <th>📅 Fecha</th>
                        <th class="text-center" colspan="2">Acciones</th>
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
                            <td>
                                <span class="badge bg-{{ $grade->grade >= 5 ? 'success' : 'danger' }}">
                                    {{ number_format($grade->grade, 2) }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($grade->date)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('tutor.calificaciones.edit', ['grade' => $grade->id]) }}" class="btn btn-sm btn-outline-warning">
                                    ✏️ Editar
                                </a>
                            </td>
                            <td class="text-center">
                                <form method="POST" action="{{ route('tutor.calificaciones.destroy', ['grade' => $grade->id]) }}" onsubmit="return confirm('¿Estás seguro de eliminar esta calificación?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        🗑️ Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
