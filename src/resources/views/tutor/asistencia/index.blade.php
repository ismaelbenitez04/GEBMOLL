@extends('layouts.user')

@section('content')
@foreach ($alumnos as $alumno)
    <div class="card mb-3">
        <div class="card-header">
            {{ $alumno->name }}
        </div>
        <div class="card-body">
            @if ($alumno->justificaciones->isEmpty())
                <p>No hay justificaciones registradas.</p>
            @else
                <ul class="list-group">
                    @foreach ($alumno->justificaciones as $justificacion)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $justificacion->subject->name ?? 'Sin asignatura' }} -
                            {{ $justificacion->date }}:
                            <strong>{{ $justificacion->motivo }}</strong>

                            @if ($justificacion->estado == 'pendiente')
                                <form action="{{ route('tutor.justificaciones.responder', $justificacion->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" name="accion" value="aceptar" class="btn btn-success btn-sm">Aceptar</button>
                                    <button type="submit" name="accion" value="denegar" class="btn btn-danger btn-sm">Denegar</button>
                                </form>
                            @else
                                <span class="badge {{ $justificacion->estado == 'aceptado' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($justificacion->estado) }}
                                </span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endforeach
@endsection