@extends('layouts.user')

@section('title', 'Nueva Calificación')

@section('content')
<div class="container">
    <div class="mb-4">
        <h1 class="fw-semibold text-primary">Registrar Nueva Calificación</h1>
        <p class="text-muted">Completa el siguiente formulario para registrar una nota.</p>
    </div>

    <form action="{{ route('calificaciones.store') }}" method="POST">
        @csrf

        <!-- Alumno -->
        <div class="mb-3">
            <label for="user_id" class="form-label">Alumno</label>
            <select name="user_id" id="user_id" class="form-select rounded-3 shadow-sm" required>
                <option value="">Seleccione un alumno</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Asignatura -->
        <div class="mb-3">
            <label for="subject_id" class="form-label">Asignatura</label>
            <select name="subject_id" id="subject_id" class="form-select rounded-3 shadow-sm" required>
                <option value="">Seleccione una asignatura</option>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Nota -->
        <div class="mb-3">
            <label for="grade" class="form-label">Nota</label>
            <input type="number" step="0.01" min="0" max="10" class="form-control rounded-3 shadow-sm" name="grade" id="grade" required>
        </div>

        <!-- Fecha -->
        <div class="mb-4">
            <label for="date" class="form-label">Fecha</label>
            <input type="date" class="form-control rounded-3 shadow-sm" name="date" id="date" required>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('calificaciones.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar Calificación</button>
        </div>
    </form>
</div>
@endsection
