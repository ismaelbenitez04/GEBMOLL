@extends('layouts.user')

@section('title', 'Editar Asistencia')

@section('content')
<div class="container">
    <div class="mb-4">
        <h1 class="fw-semibold text-primary">Editar Asistencia</h1>
        <p class="text-muted">Modifica la información registrada de la asistencia del alumno.</p>
    </div>

    <form method="POST" action="{{ route('asistencia.update', $attendance->id) }}">
        @csrf
        @method('PUT')

        <!-- Fecha -->
        <div class="mb-3">
            <label for="date" class="form-label">Fecha</label>
            <input type="date" name="date" class="form-control rounded-3 shadow-sm" value="{{ $attendance->date }}" required>
        </div>

        <!-- Alumno -->
        <div class="mb-3">
            <label class="form-label">Alumno</label>
            <input class="form-control rounded-3 bg-light" type="text" value="{{ $attendance->user->name }}" disabled>
        </div>

        <!-- Asignatura -->
        <div class="mb-3">
            <label class="form-label">Asignatura</label>
            <input class="form-control rounded-3 bg-light" type="text" value="{{ $attendance->subject->name }}" disabled>
        </div>

        <!-- Estado -->
        <div class="mb-4">
            <label for="status" class="form-label">Estado</label>
            <select name="status" id="status" class="form-select rounded-3 shadow-sm" required>
                <option value="present" {{ $attendance->status === 'presente' ? 'selected' : '' }}>Presente</option>
                <option value="absent" {{ $attendance->status === 'ausente' ? 'selected' : '' }}>Ausente</option>
                <option value="late" {{ $attendance->status === 'retraso' ? 'selected' : '' }}>Retraso</option>
            </select>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('asistencia.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
    </form>
</div>
@endsection
