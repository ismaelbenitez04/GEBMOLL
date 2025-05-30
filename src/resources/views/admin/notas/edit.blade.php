@extends('layouts.admin')

@section('title', 'Editar Nota')

@section('content')

<form action="{{ route('admin.notas.update', $nota->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="user_id" class="form-label">Alumno</label>
        <select name="user_id" id="user_id" class="form-select" required>
            @foreach($alumnos as $alumno)
                <option value="{{ $alumno->id }}" {{ $nota->user_id == $alumno->id ? 'selected' : '' }}>
                    {{ $alumno->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="subject_id" class="form-label">Asignatura</label>
        <select name="subject_id" id="subject_id" class="form-select" required>
            @foreach ($asignaturas as $subject)
                <option value="{{ $subject->id }}" {{ $nota->subject_id == $subject->id ? 'selected' : '' }}>
                    {{ $subject->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="grade" class="form-label">Nota</label>
        <input type="number" name="grade" id="grade" class="form-control" value="{{ old('grade', $nota->grade) }}" step="0.01" min="0" max="10" required>
    </div>

    <button class="btn btn-primary" type="submit">Actualizar</button>
</form>
@endsection
