@extends('layouts.user')

@section('title', 'Justificaciones pendientes')

@section('content')
    <h2>Justificaciones pendientes</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Alumno</th>
                <th>Asignatura</th>
                <th>Fecha</th>
                <th>Motivo</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($faltas as $falta)
                <tr>
                    <td>{{ $falta->user->name }}</td>
                    <td>{{ $falta->subject->name }}</td>
                    <td>{{ $falta->date }}</td>
                    <td>{{ $falta->justification }}</td>
                    <td>
                        <form action="{{ route('tutor.justificaciones.responder', $falta) }}" method="POST" class="d-flex">
                            @csrf
                            <button name="accion" value="aceptada" class="btn btn-success btn-sm me-1">Aceptar</button>
                            <button name="accion" value="rechazada" class="btn btn-danger btn-sm">Rechazar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
