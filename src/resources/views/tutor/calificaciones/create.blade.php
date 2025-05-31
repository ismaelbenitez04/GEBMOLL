@extends('layouts.user')

@section('title', 'Registrar Calificación')

@section('content')
<div class="container">
    <h1 class="mb-4 text-primary fw-semibold">Registrar Nueva Calificación</h1>

    <form action="{{ route('calificaciones.store') }}" method="POST" class="bg-white p-4 rounded shadow-sm">
        @csrf

        {{-- Alumno --}}
        <div class="mb-3">
            <label for="user_id" class="form-label">👤 Alumno</label>
            <select name="user_id" id="user_id" class="form-select" required>
                <option value="">Seleccione un alumno</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Asignatura --}}
        <div class="mb-3">
            <label for="subject_id" class="form-label">📘 Asignatura</label>
            <select name="subject_id" id="subject_id" class="form-select" required>
                <option value="">Seleccione una asignatura</option>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Nota --}}
        <div class="mb-3">
            <label for="grade" class="form-label">📈 Nota</label>
            <input type="number" step="0.01" min="0" max="10" class="form-control" name="grade" id="grade" required placeholder="Ej: 8.75">
        </div>

        {{-- Fecha --}}
        <div class="mb-3">
            <label for="date" class="form-label">📅 Fecha</label>
            <input type="date" class="form-control" name="date" id="date" required>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-success">
                💾 Guardar Calificación
            </button>
            <a href="{{ route('calificaciones.index') }}" class="btn btn-outline-secondary">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
