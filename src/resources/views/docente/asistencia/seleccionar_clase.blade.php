@extends('layouts.user')

@section('title', 'Seleccionar clase')

@section('content')
<div class="container">
    <div class="mb-4">
        <h1 class="fw-semibold text-primary">Selecciona una clase</h1>
        <p class="text-muted">Elige una asignatura para registrar la asistencia de hoy.</p>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <ul class="list-group list-group-flush">
                @forelse ($clases as $clase)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="fw-medium">{{ $clase->name }}</span>
                        <a href="{{ route('asistencia.pasarLista', $clase->id) }}" class="btn btn-sm btn-outline-primary">
                            Pasar lista
                        </a>
                    </li>
                @empty
                    <li class="list-group-item text-muted">No tienes clases asignadas.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
