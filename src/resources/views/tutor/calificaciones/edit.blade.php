@extends('layouts.user')

@section('title', 'Editar Calificación')

@section('content')
<div class="container">
    <h1 class="mb-4 text-primary fw-bold">Editar Calificación</h1>

    <form action="{{ route('calificaciones.update', ['grade' => $grade->id]) }}" method="POST" class="bg-white p-4 rounded shadow-sm">
        @csrf
        @method('PUT')

        {{-- Alumno (solo lectura) --}}
        <div class="mb-3">
            <label for="user_id" class="form-label">👤 Alumno</label>
            <select name="user_id" id="user_id" class="form-select" disabled>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}" {{ $student->id == $grade->user_id ? 'selected' : '' }}>
                        {{ $student->name }}
                    </option>
                @endforeach
            </select>
            <div class="form-text text-muted">Este campo no se puede editar</div>
        </div>

        {{-- Asignatura (solo lectura) --}}
        <div class="mb-3">
            <label for="subject_id" class="form-label">📘 Asignatura</label>
            <select name="subject_id" id="subject_id" class="form-select" disabled>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ $subject->id == $grade->subject_id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
            <div class="form-text text-muted">Este campo no se puede editar</div>
        </div>

        {{-- Nota --}}
        <div class="mb-3">
            <label for="grade" class="form-label">📈 Nota</label>
            <input type="number" name="grade" id="grade" step="0.01" min="0" max="10" class="form-control" value="{{ $grade->grade }}" required>
        </div>

        {{-- Fecha --}}
        <div class="mb-3">
            <label for="date" class="form-label">📅 Fecha</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ $grade->date }}" required>
        </div>

        {{-- Acciones --}}
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary">
                💾 Actualizar
            </button>
            <a href="{{ route('calificaciones.index') }}" class="btn btn-outline-secondary">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
