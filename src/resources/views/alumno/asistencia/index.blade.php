@extends('layouts.user')

@section('title', 'Asistencia')

@section('content')
    <div class="mb-4">
        <h1 class="fw-semibold text-primary">Mi Asistencia</h1>
        <p class="text-muted">Aquí puedes revisar y justificar tus ausencias.</p>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Asignatura</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                            <tr>
                                <td>{{ $attendance->subject->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d/m/Y') }}</td>
                                <td>
                                    @if ($attendance->justification_status === 'aceptada')
                                        <span class="badge bg-success">Aceptada</span>
                                    @elseif ($attendance->justification_status === 'rechazada')
                                        <span class="badge bg-danger">Rechazada</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    @endif
                                </td>
                                <td>
                                    @if (!$attendance->justificado)
                                        <form action="{{ route('alumno.asistencia.justificar', $attendance->id) }}" method="POST">
                                            @csrf
                                            <div class="mb-2">
                                                <textarea name="motivo" class="form-control" rows="2" required placeholder="Motivo de la justificación"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-outline-primary">Justificar</button>
                                        </form>
                                    @else
                                        <span class="badge bg-success">Justificada</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
