@extends('layouts.user')

@section('content')
<div class="container">
    <h2>Editar Asistencia</h2>

    <form method="POST" action="{{ route('asistencia.update', $attendance->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="date" class="form-label">Fecha</label>
            <input type="date" name="date" class="form-control" value="{{ $attendance->date }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Alumno</label>
            <input class="form-control" type="text" value="{{ $attendance->user->name }}" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Asignatura</label>
            <input class="form-control" type="text" value="{{ $attendance->subject->name }}" disabled>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Estado</label>
            <select name="status" id="status" class="form-select" required>
                <option value="present" {{ $attendance->status === 'presente' ? 'selected' : '' }}>Presente</option>
                <option value="absent" {{ $attendance->status === 'ausente' ? 'selected' : '' }}>Ausente</option>
                <option value="late" {{ $attendance->status === 'retraso' ? 'selected' : '' }}>Retraso</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('asistencia.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
