@extends('layouts.user')

@section('title', 'Inicio Alumno')

@section('content')
<div class="container">
    <h1 class="mb-4 fw-semibold">Bienvenido, {{ auth()->user()->name }}</h1>

    <div class="row g-4">
        <!-- Tareas Pendientes -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h6 class="text-primary fw-semibold mb-2">Tareas Pendientes</h6>
                    <h2 class="fw-bold">{{ $tareasPendientes->count() }}</h2>
                    <p class="text-muted">Tienes tareas por completar.</p>
                    <a href="{{ route('alumno.tareas') }}" class="btn btn-sm btn-outline-primary">Ver Tareas</a>
                </div>
            </div>
        </div>

        <!-- Mensajes sin leer -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h6 class="text-danger fw-semibold mb-2">Mensajes sin leer</h6>
                    <h2 class="fw-bold">{{ $mensajesSinLeer->count() }}</h2>
                    <p class="text-muted">Revisa tus chats pendientes.</p>
                    <a href="{{ route('mensajes.index') }}" class="btn btn-sm btn-outline-danger">Ir a Mensajes</a>
                </div>
            </div>
        </div>

        <!-- Últimas Calificaciones -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    <h6 class="text-success fw-semibold mb-3">Últimas Calificaciones</h6>
                    <ul class="list-group list-group-flush mb-2">
                        @forelse ($calificaciones as $nota)
                            <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                <span>{{ $nota->subject->name ?? 'Sin asignatura' }}</span>
                                <strong>{{ $nota->grade }}</strong>
                            </li>
                        @empty
                            <li class="list-group-item px-0">Sin calificaciones recientes</li>
                        @endforelse
                    </ul>
                    <a href="{{ route('alumno.calificaciones') }}" class="btn btn-sm btn-outline-success">Ver todas</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
