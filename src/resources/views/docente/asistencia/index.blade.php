@extends('layouts.user')

@section('title', 'Asistencia')

@section('content')
<div class="container">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-semibold text-primary">Asistencia</h1>
            <p class="text-muted mb-0">Consulta y gestiona los registros de asistencia.</p>
        </div>
        <a href="{{ route('asistencia.clases') }}" class="btn btn-outline-primary">Registrar asistencia</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($attendances->isEmpty())
        <div class="alert alert-info">No hay registros de asistencia.</div>
    @else
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Alumno</th>
                            <th>Asignatura</th>
                            <th>Fecha</th>
                            <th>Presente</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendances as $att)
                            <tr>
                                <td>{{ $att->user->name ?? '—' }}</td>
                                <td>{{ $att->subject->name ?? '—' }}</td>
                                <td>{{ \Carbon\Carbon::parse($att->date)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge {{ $att->present ? 'bg-success' : 'bg-danger' }}">
                                        {{ $att->present ? 'Sí' : 'No' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('asistencia.edit', $att->id) }}" class="btn btn-sm btn-outline-warning">
                                        Editar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
