@extends('layouts.admin')

@section('title', 'Inicio - Administración')

@section('content')
<div class="container">

    <div class="row g-4">

        <!-- Gestión de Alumnos -->
        <div class="col-md-4">
            <div class="card border-primary h-100">
                <div class="card-header bg-primary text-white">
                    Gestión de Alumnos
                </div>
                <div class="card-body">
                    <p class="card-text">Agregar, eliminar o mover alumnos entre clases.</p>
                    <a href="{{ route('admin.alumnos.index') }}" class="btn btn-primary">Ver Alumnos</a>
                </div>
            </div>
        </div>

        <!-- Gestión de Docentes -->
        <div class="col-md-4">
            <div class="card border-success h-100">
                <div class="card-header bg-success text-white">
                    Gestión de Docentes
                </div>
                <div class="card-body">
                    <p class="card-text">Crear o eliminar docentes, asignar clases.</p>
                    <a href="{{ route('admin.docentes.index') }}" class="btn btn-success">Ver Docentes</a>
                </div>
            </div>
        </div>

        <!-- Gestión de Tutores -->
        <div class="col-md-4">
            <div class="card border-warning h-100">
                <div class="card-header bg-warning text-white">
                    Gestión de Tutores
                </div>
                <div class="card-body">
                    <p class="card-text">Crear o eliminar tutores, asignar clases.</p>
                    <a href="{{ route('admin.tutores.index') }}" class="btn btn-warning">Ver Tutores</a>
                </div>
            </div>
        </div>

        <!-- Asignar Notas -->
        <div class="col-md-6">
            <div class="card border-info h-100">
                <div class="card-header bg-info text-white">
                    Asignar Notas
                </div>
                <div class="card-body">
                    <p class="card-text">Asignar o modificar notas de cualquier alumno en sus asignaturas.</p>
                    <a href="{{ route('admin.notas.index') }}" class="btn btn-info">Gestionar Notas</a>
                </div>
            </div>
        </div>

        <!-- Logs de Cambios -->
        <div class="col-md-6">
            <div class="card border-secondary h-100">
                <div class="card-header bg-secondary text-white">
                    Registro de Cambios (Logs)
                </div>
                <div class="card-body">
                    <p class="card-text">Visualizar el historial de modificaciones con fecha y usuario.</p>
                    <a href="{{ route('admin.logs.index') }}" class="btn btn-secondary">Ver Logs</a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
