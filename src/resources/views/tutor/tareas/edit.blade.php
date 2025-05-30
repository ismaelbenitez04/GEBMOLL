@extends('layouts.user')

@section('title', 'Editar Tarea')

@section('content')
<div class="container">
    <h2>Editar Tarea</h2>

    <form action="{{ route('tutor.tareas.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="subject_id" class="form-label">Asignatura</label>
            <select name="subject_id" id="subject_id" class="form-select" required>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}" @selected($subject->id == $task->subject_id)>{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" id="description" class="form-control" required>{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">Fecha de entrega</label>
            <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date', $task->due_date) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Tarea</button>
        <a href="{{ route('tutor.tareas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
