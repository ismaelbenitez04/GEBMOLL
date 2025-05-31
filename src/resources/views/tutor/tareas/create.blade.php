@extends('layouts.user')

@section('title', 'Crear Tarea')

@section('content')
<div class="container">
    <h1 class="mb-4 text-primary fw-bold">✍️ Nueva Tarea</h1>

    <form action="{{ route('tutor.tareas.store') }}" method="POST" class="bg-white p-4 rounded shadow-sm">
        @csrf

        {{-- Asignatura --}}
        <div class="mb-3">
            <label for="subject_id" class="form-label">📘 Asignatura</label>
            <select name="subject_id" id="subject_id" class="form-select @error('subject_id') is-invalid @enderror" required>
                <option value="">Selecciona una asignatura</option>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
            @error('subject_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Descripción --}}
        <div class="mb-3">
            <label for="description" class="form-label">📝 Descripción</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Fecha de entrega --}}
        <div class="mb-3">
            <label for="due_date" class="form-label">📅 Fecha de entrega</label>
            <input type="date" name="due_date" id="due_date" class="form-control @error('due_date') is-invalid @enderror" value="{{ old('due_date') }}" required>
            @error('due_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Botones --}}
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-success">💾 Guardar</button>
            <a href="{{ route('tutor.tareas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
