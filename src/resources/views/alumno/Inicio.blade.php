@extends('layouts.user')

@section('title', 'Inicio Alumno')

@section('content')
<div class="container">
    <h1 class="mb-4">Bienvenido, {{ auth()->user()->name }}</h1>

    <div class="row">
        <!-- Tareas Pendientes -->
        <div class="col-md-4">
            <div class="card border-primary mb-3">
                <div class="card-header bg-primary text-white">Tareas Pendientes</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $tareasPendientes->count() }}</h5>
                    <p class="card-text">Tienes tareas por completar.</p>
                    <a href="{{ route('alumno.tareas') }}" class="btn btn-sm btn-primary">Ver Tareas</a>
                </div>
            </div>
        </div>

        <!-- Mensajes sin leer -->
        <div class="col-md-4">
            <div class="card border-danger mb-3">
                <div class="card-header bg-danger text-white">Mensajes sin leer</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $mensajesSinLeer->count() }}</h5>
                    <p class="card-text">Revisa tus chats pendientes.</p>
                    <a href="{{ route('mensajes.index') }}" class="btn btn-sm btn-danger">Ir a Mensajes</a>
                </div>
            </div>
        </div>

        <!-- Últimas Calificaciones -->
        <div class="col-md-4">
            <div class="card border-success mb-3">
                <div class="card-header bg-success text-white">Últimas Calificaciones</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse ($calificaciones as $nota)
                            <li class="list-group-item">
                                {{ $nota->subject->name ?? 'Sin asignatura' }}: <strong>{{ $nota->grade }}</strong>
                            </li>
                        @empty
                            <li class="list-group-item">Sin calificaciones recientes</li>
                        @endforelse
                    </ul>
                    <a href="{{ route('alumno.calificaciones') }}" class="btn btn-sm btn-success mt-2">Ver todas</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
