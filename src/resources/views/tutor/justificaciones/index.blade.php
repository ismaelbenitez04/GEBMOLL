@extends('layouts.user')

@section('title', 'Justificaciones de Faltas')

@section('content')
<div class="container">
    <h1 class="mb-4">Justificaciones de Faltas</h1>

    @if($justificaciones->isEmpty())
        <p>No hay justificaciones pendientes.</p>
    @else
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Alumno</th>
                    <th>Asignatura</th>
                    <th>Fecha</th>
                    <th>Motivo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($justificaciones as $j)
                    <tr>
                        <td>{{ $j->user->name }}</td>
                        <td>{{ $j->subject->name }}</td>
                        <td>{{ $j->date }}</td>
                        <td>{{ $j->motivo }}</td>
                        <td>
                            @if ($j->estado === 'pendiente')
                                <span class="badge bg-warning text-dark">Pendiente</span>
                            @elseif ($j->estado === 'aceptada')
                                <span class="badge bg-success">Aceptada</span>
                            @else
                                <span class="badge bg-danger">Rechazada</span>
                            @endif
                        </td>
                        <td>
                            @if ($j->estado === 'pendiente')
                                <form action="{{ route('tutor.justificaciones.update', $j->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="estado" value="aceptada">
                                    <button class="btn btn-success btn-sm">Aceptar</button>
                                </form>
                                <form action="{{ route('tutor.justificaciones.update', $j->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="estado" value="rechazada">
                                    <button class="btn btn-danger btn-sm">Rechazar</button>
                                </form>
                            @else
                                <em>Ya gestionada</em>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
