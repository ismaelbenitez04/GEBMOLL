@extends('layouts.user')

@section('content')
<div class="container">
    <h2>Crear nueva tarea</h2>

    <form action="{{ route('tutor.tareas.store') }}" method="POST">
        @csrf

        {{-- Asignatura --}}
        <div class="mb-3">
            <label for="subject_id" class="form-label">Asignatura</label>
            <select name="subject_id" id="subject_id" class="form-select" required>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
            @error('subject_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Descripción --}}
        <div class="mb-3">
            <label for="description" class="form-label">Descripción de la tarea</label>
            <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Fecha de entrega --}}
        <div class="mb-3">
            <label for="due_date" class="form-label">Fecha de entrega</label>
            <input type="date" name="due_date" id="due_date" class="form-control" required value="{{ old('due_date') }}">
            @error('due_date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Guardar tarea</button>
        <a href="{{ route('tutor.tareas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
