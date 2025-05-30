@extends('layouts.admin')

@section('title', 'Crear Nota')

@section('content')

<form action="{{ route('admin.notas.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="user_id" class="form-label">Alumno</label>
        <select name="user_id" id="user_id" class="form-select" required>
            <option value="">Seleccione un alumno</option>
            @foreach ($alumnos as $alumno)
                <option value="{{ $alumno->id }}">{{ $alumno->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="subject_id" class="form-label">Asignatura</label>
        <select name="subject_id" id="subject_id" class="form-select" required>
            <option value="">Seleccione una asignatura</option>
            @foreach ($asignaturas as $asignatura)
                <option value="{{ $asignatura->id }}">{{ $asignatura->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="grade" class="form-label">Nota</label>
        <input type="number" name="grade" id="grade" class="form-control" min="0" max="10" step="0.1" required>
    </div>

    <button type="submit" class="btn btn-primary">Crear Nota</button>
</form>
@endsection
