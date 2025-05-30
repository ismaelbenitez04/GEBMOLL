@extends('layouts.user')

@section('title', 'Inicio Tutor')

@section('content')
<h1 class="mb-4">Inicio</h1>

<div class="row">
    <!-- Alumnos tutelados -->
    <div class="col-md-6">
        <div class="card border-info mb-3">
            <div class="card-header bg-info text-white">Tutorandos</div>
            <div class="card-body">
                <h5 class="card-title">{{ $totalAlumnos }}</h5>
                <p class="card-text">Alumnos asignados a tu tutoría.</p>
                <a href="{{ route('tutor.tutorandos') }}" class="btn btn-sm btn-info">Ver Alumnos</a>
            </div>
        </div>
    </div>

    <!-- Mensajes pendientes -->
    <div class="col-md-6">
        <div class="card border-warning mb-3">
            <div class="card-header bg-warning text-dark">Mensajes sin leer</div>
            <div class="card-body">
                <h5 class="card-title">{{ $mensajesPendientes }}</h5>
                <p class="card-text">Mensajes pendientes por revisar.</p>
                <a href="{{ route('mensajes.index') }}" class="btn btn-sm btn-warning">Ver mensajes</a>
            </div>
        </div>
    </div>
</div>
@endsection
