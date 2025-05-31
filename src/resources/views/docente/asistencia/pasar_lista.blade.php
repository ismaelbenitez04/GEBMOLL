@extends('layouts.user')

@section('title', 'Registrar Asistencia')

@section('content')
<div class="container">
    <div class="mb-4">
        <h1 class="fw-semibold text-primary">Registrar asistencia para {{ $group->name }}</h1>
        <p class="text-muted">Marca la asistencia de los alumnos para una asignatura en una fecha determinada.</p>
    </div>

    <form method="POST" action="{{ route('asistencia.store') }}">
        @csrf

        <!-- Fecha -->
        <div class="mb-3">
            <label for="date" class="form-label">Fecha</label>
            <input type="date" name="date" class="form-control rounded-3 shadow-sm" required>
        </div>

        <!-- Asignatura -->
        <div class="mb-4">
            <label for="subject_id" class="form-label">Asignatura</label>
            <select name="subject_id" class="form-select rounded-3 shadow-sm" required>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Lista de alumnos -->
        <div class="mb-4">
            <h4 class="fw-semibold text-secondary">Alumnos</h4>
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body">
                    @foreach ($students as $student)
                        <div class="mb-3">
                            <strong>{{ $student->name }}</strong><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status[{{ $student->id }}]" value="present" required>
                                <label class="form-check-label">Presente</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status[{{ $student->id }}]" value="absent" required>
                                <label class="form-check-label">Ausente</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status[{{ $student->id }}]" value="late" required>
                                <label class="form-check-label">Tarde</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Botón -->
        <div class="text-end">
            <button type="submit" class="btn btn-success px-4">Guardar asistencia</button>
        </div>
    </form>
</div>
@endsection
