@extends('layouts.user')

@section('content')
<div class="container">
    <h2>Crear tarea</h2>
    <form action="{{ route('tareas.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Asignatura</label>
            <select name="subject_id" class="form-select">
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Fecha de entrega</label>
            <input type="date" name="due_date" class="form-control" required>
        </div>
        <button class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
