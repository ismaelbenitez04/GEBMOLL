@extends('layouts.user')

@section('title', 'Editar Calificación')

@section('content')
<div class="container">
    <div class="mb-4">
        <h1 class="fw-semibold text-primary">Editar Calificación</h1>
        <p class="text-muted">Modifica la nota y la fecha de esta calificación registrada.</p>
    </div>

    <form action="{{ route('calificaciones.update', ['grade' => $grade->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Alumno -->
        <div class="mb-3">
            <label for="user_id" class="form-label">Alumno</label>
            <select name="user_id" id="user_id" class="form-select rounded-3 shadow-sm" disabled>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}" {{ $student->id == $grade->user_id ? 'selected' : '' }}>
                        {{ $student->name }}
                    </option>
                @endforeach
            </select>
            <div class="form-text text-muted">El alumno no se puede cambiar.</div>
        </div>

        <!-- Asignatura -->
        <div class="mb-3">
            <label for="subject_id" class="form-label">Asignatura</label>
            <select name="subject_id" id="subject_id" class="form-select rounded-3 shadow-sm" disabled>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ $subject->id == $grade->subject_id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
            <div class="form-text text-muted">La asignatura no se puede cambiar.</div>
        </div>

        <!-- Nota -->
        <div class="mb-3">
            <label for="grade" class="form-label">Nota</label>
            <input type="number" step="0.01" min="0" max="10" class="form-control rounded-3 shadow-sm"
                   name="grade" id="grade" value="{{ $grade->grade }}" required>
        </div>

        <!-- Fecha -->
        <div class="mb-4">
            <label for="date" class="form-label">Fecha</label>
            <input type="date" class="form-control rounded-3 shadow-sm" name="date" id="date"
                   value="{{ $grade->date }}" required>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('calificaciones.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Actualizar Calificación</button>
        </div>
    </form>
</div>
@endsection
