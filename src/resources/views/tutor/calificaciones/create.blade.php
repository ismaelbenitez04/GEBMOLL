@extends('layouts.user')

@section('content')
<div class="container">
    <h2 class="mb-4">Registrar Nueva Calificación</h2>

    <form action="{{ route('calificaciones.store') }}" method="POST">
        @csrf

        {{-- Alumno --}}
        <div class="mb-3">
            <label for="user_id" class="form-label">Alumno</label>
            <select name="user_id" id="user_id" class="form-select" required>
                <option value="">Seleccione un alumno</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Asignatura --}}
        <div class="mb-3">
            <label for="subject_id" class="form-label">Asignatura</label>
            <select name="subject_id" id="subject_id" class="form-select" required>
                <option value="">Seleccione una asignatura</option>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Nota --}}
        <div class="mb-3">
            <label for="grade" class="form-label">Nota</label>
            <input type="number" step="0.01" min="0" max="10" class="form-control" name="grade" id="grade" required>
        </div>

        {{-- Fecha --}}
        <div class="mb-3">
            <label for="date" class="form-label">Fecha</label>
            <input type="date" class="form-control" name="date" id="date" required>
        </div>

        <button type="submit" class="btn btn-success">Guardar Calificación</button>
        <a href="{{ route('calificaciones.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
