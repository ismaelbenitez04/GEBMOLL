@extends('layouts.user')

@section('title', 'Gestión de Tareas')

@section('content')
<div class="container">
    <h1 class="mb-4 text-primary fw-bold">📚 Tareas Asignadas</h1>

    <a href="{{ route('tutor.tareas.create') }}" class="btn btn-success mb-4">➕ Crear Nueva Tarea</a>

    @if($tasks->isEmpty())
        <div class="alert alert-info">No hay tareas registradas actualmente.</div>
    @else
        <div class="row">
            @foreach ($tasks as $task)
                <div class="col-md-6">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-primary">{{ $task->subject->name }}</h5>
                            <p class="card-text flex-grow-1">{{ $task->description }}</p>
                            <small class="text-muted">📅 Entrega: {{ $task->due_date }}</small>

                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <a href="{{ route('tutor.tareas.edit', $task->id) }}" class="btn btn-sm btn-outline-primary">✏️ Editar</a>
                                <form action="{{ route('tutor.tareas.destroy', $task->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar esta tarea?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">🗑️ Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
