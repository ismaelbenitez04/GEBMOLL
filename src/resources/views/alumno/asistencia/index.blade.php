@extends('layouts.user')

@section('content')
<div class="container">
    <h2 class="mb-4">Mi Asistencia</h2>

    {{-- Filtros --}}
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label class="form-label">Asignatura</label>
            <select name="subject_id" class="form-select">
                <option value="">Todas</option>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Desde</label>
            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
        </div>

        <div class="col-md-3">
            <label class="form-label">Hasta</label>
            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
        </div>

        <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
    </form>

    {{-- Gráfico --}}
    <canvas id="attendanceChart" height="100"></canvas>

    {{-- Tabla --}}
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Asignatura</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->subject->name ?? '—' }}</td>
                    <td>{{ $attendance->date }}</td>
                    <td>
                        @if ($attendance->status === 'present')
                            <span class="badge bg-success">Presente</span>
                        @elseif ($attendance->status === 'absent')
                            <span class="badge bg-danger">Ausente</span>
                        @elseif ($attendance->status === 'late')
                            <span class="badge bg-warning text-dark">Retraso</span>
                        @else
                            <span class="badge bg-secondary">Desconocido</span>
                        @endif
                    </td>
                </tr>
               <form action="{{ route('alumno.asistencia.justificar', $attendance->id) }}" method="POST">
                    @csrf
                    <textarea name="motivo" required placeholder="Escribe el motivo de la justificación"></textarea>
                    <button type="submit" class="btn btn-primary">Justificar</button>
                </form>

            @empty
                <tr>
                    <td colspan="3">No hay registros</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('attendanceChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Presente', 'Ausente', 'Retraso'],
            datasets: [{
                label: 'Número de asistencias',
                data: [{{ $stats['present'] }}, {{ $stats['absent'] }}, {{ $stats['late'] }}],
                borderWidth: 1
            }]
        },
        options: {
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
@endsection
