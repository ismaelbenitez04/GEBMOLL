@extends('layouts.user')

@section('title', 'Mis Calificaciones')

@section('content')
<div class="container">
    <div class="mb-4">
        <h1 class="fw-semibold text-primary">Mis Calificaciones</h1>
        <p class="text-muted">Consulta tus notas obtenidas por asignatura.</p>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Asignatura</th>
                            <th>Nota</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($grades as $grade)
                            <tr>
                                <td>{{ $grade->subject->name ?? '—' }}</td>
                                <td>
                                    <span class="fw-bold">{{ $grade->grade }}</span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($grade->date)->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">No hay calificaciones registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
