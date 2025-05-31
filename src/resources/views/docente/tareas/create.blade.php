@extends('layouts.user')

@section('title', 'Crear Tarea')

@section('content')
<div class="container">
    <div class="mb-4">
        <h1 class="fw-semibold text-primary">Crear nueva tarea</h1>
        <p class="text-muted">Completa los campos para asignar una tarea a tus alumnos.</p>
    </div>

    <form action="{{ route('tareas.store') }}" method="POST">
        @csrf

        <!-- Asignatura -->
        <div class="mb-3">
            <label for="subject_id" class="form-label">Asignatura</label>
            <select name="subject_id" id="subject_id" class="form-select rounded-3 shadow-sm" required>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Descripción -->
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" id="description" class="form-control rounded-3 shadow-sm" rows="4" required></textarea>
        </div>

        <!-- Fecha de entrega -->
        <div class="mb-4">
            <label for="due_date" class="form-label">Fecha de entrega</label>
            <input type="date" name="due_date" id="due_date" class="form-control rounded-3 shadow-sm" required>
        </div>

        <!-- Botón -->
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Guardar tarea</button>
        </div>
    </form>
</div>
@endsection
