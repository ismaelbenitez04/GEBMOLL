@extends('layouts.user')

@section('title', 'Justificaciones de Alumnos')

@section('content')
<div class="container">
    <h1 class="fw-semibold mb-4 text-primary">Justificaciones de Tutorandos</h1>

    @foreach ($alumnos as $alumno)
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-light fw-semibold">
                {{ $alumno->name }}
            </div>
            <div class="card-body">
                @if ($alumno->justificaciones->isEmpty())
                    <p class="text-muted">No hay justificaciones registradas.</p>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach ($alumno->justificaciones as $justificacion)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-medium">{{ $justificacion->subject->name ?? 'Sin asignatura' }}</div>
                                    <div class="small text-muted">
                                        {{ \Carbon\Carbon::parse($justificacion->date)->format('d/m/Y') }} - 
                                        <em>{{ $justificacion->motivo }}</em>
                                    </div>
                                </div>

                                <div>
                                    @if ($justificacion->estado === 'pendiente')
                                        <form action="{{ route('tutor.justificaciones.responder', $justificacion->id) }}" method="POST" class="d-flex gap-2">
                                            @csrf
                                            <button type="submit" name="accion" value="aceptar" class="btn btn-sm btn-outline-success">Aceptar</button>
                                            <button type="submit" name="accion" value="denegar" class="btn btn-sm btn-outline-danger">Denegar</button>
                                        </form>
                                    @else
                                        <span class="badge {{ $justificacion->estado === 'aceptado' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($justificacion->estado) }}
                                        </span>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
