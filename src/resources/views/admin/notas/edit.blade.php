@extends('layouts.admin')

@section('title', 'Editar Nota')

@section('content')
<div class="container">
    <h2 class="mb-4 fw-bold">✏️ Editar Nota</h2>

    <form action="{{ route('admin.notas.update', $nota->id) }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        {{-- Alumno --}}
        <div class="mb-3">
            <label for="user_id" class="form-label">👨‍🎓 Alumno</label>
            <select name="user_id" id="user_id" class="form-select" required>
                @foreach($alumnos as $alumno)
                    <option value="{{ $alumno->id }}" {{ $nota->user_id == $alumno->id ? 'selected' : '' }}>
                        {{ $alumno->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Asignatura --}}
        <div class="mb-3">
            <label for="subject_id" class="form-label">📚 Asignatura</label>
            <select name="subject_id" id="subject_id" class="form-select" required>
                @foreach ($asignaturas as $subject)
                    <option value="{{ $subject->id }}" {{ $nota->subject_id == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Nota --}}
        <div class="mb-3">
            <label for="grade" class="form-label">📈 Nota</label>
            <input type="number" name="grade" id="grade" class="form-control" value="{{ old('grade', $nota->grade) }}" step="0.01" min="0" max="10" required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.notas.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Actualizar Nota</button>
        </div>
    </form>
</div>
@endsection
