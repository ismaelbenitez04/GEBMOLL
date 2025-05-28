@extends('layouts.user')

@section('content')
<div class="container">
    <h2 class="mb-4">Asistencia</h2>

    <a href="{{ route('asistencia.clases') }}" class="btn btn-primary mb-3">Registrar asistencia</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($attendances->isEmpty())
        <div class="alert alert-info">No hay registros de asistencia.</div>
        
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Alumno</th>
                    <th>Asignatura</th>
                    <th>Fecha</th>
                    <th>Presente</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $att)
                    <tr>
                        <td>{{ $att->user->name ?? '—' }}</td>
                        <td>{{ $att->subject->name ?? '—' }}</td>
                        <td>{{ $att->date }}</td>
                        <td>{{ $att->present ? 'Sí' : 'No' }}</td>
                        <td>
                            <a href="{{ route('asistencia.edit', $att->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
