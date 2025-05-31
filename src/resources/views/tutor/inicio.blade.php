@extends('layouts.user')

@section('title', 'Inicio Tutor')

@section('content')
<div class="container">
    <h1 class="fw-semibold mb-4 text-primary">Panel de Tutoría</h1>

    <div class="row g-4">
        <!-- Alumnos tutelados -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4 border-start border-info border-4">
                <div class="card-body">
                    <h5 class="card-title text-info">🎓 Tutorandos</h5>
                    <h2 class="fw-bold">{{ $totalAlumnos }}</h2>
                    <p class="text-muted">Alumnos asignados a tu tutoría.</p>
                    <a href="{{ route('tutor.tutorandos') }}" class="btn btn-outline-info">Ver Alumnos</a>
                </div>
            </div>
        </div>

        <!-- Mensajes pendientes -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4 border-start border-warning border-4">
                <div class="card-body">
                    <h5 class="card-title text-warning">📨 Mensajes sin leer</h5>
                    <h2 class="fw-bold">{{ $mensajesPendientes }}</h2>
                    <p class="text-muted">Mensajes pendientes por revisar.</p>
                    <a href="{{ route('mensajes.index') }}" class="btn btn-outline-warning">Ver mensajes</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
