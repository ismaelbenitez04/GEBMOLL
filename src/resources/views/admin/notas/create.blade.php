@extends('layouts.admin')

@section('title', 'Crear Nota')

@section('content')
<div class="container">
    <h2 class="mb-4 fw-bold">✍️ Nueva Nota</h2>

    <form action="{{ route('admin.notas.store') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        {{-- Alumno --}}
        <div class="mb-3">
            <label for="user_id" class="form-label">👨‍🎓 Alumno</label>
            <select name="user_id" id="user_id" class="form-select" required>
                <option value="">Seleccione un alumno</option>
                @foreach ($alumnos as $alumno)
                    <option value="{{ $alumno->id }}">{{ $alumno->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Asignatura --}}
        <div class="mb-3">
            <label for="subject_id" class="form-label">📚 Asignatura</label>
            <select name="subject_id" id="subject_id" class="form-select" required>
                <option value="">Seleccione una asignatura</option>
                @foreach ($asignaturas as $asignatura)
                    <option value="{{ $asignatura->id }}">{{ $asignatura->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Nota --}}
        <div class="mb-3">
            <label for="grade" class="form-label">📈 Nota</label>
            <input type="number" name="grade" id="grade" class="form-control" min="0" max="10" step="0.1" placeholder="Ej: 8.5" required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.notas.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar Nota</button>
        </div>
    </form>
</div>
@endsection
