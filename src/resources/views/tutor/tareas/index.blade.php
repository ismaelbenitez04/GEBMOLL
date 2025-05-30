@extends('layouts.user')

@section('content')
<h1>Tareas</h1>

<a href="{{ route('tutor.tareas.create') }}" class="btn btn-primary mb-3">Crear nueva tarea</a>

@if($tasks->isEmpty())
    <p>No hay tareas registradas.</p>
@else
    <ul class="list-group">
       @foreach ($tasks as $task)
            <div class="card mb-3">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $task->subject->name }}</h5>
                    <p class="card-text flex-grow-1">{{ $task->description }}</p>
                    <small class="text-muted mb-2">Fecha de entrega: {{ $task->due_date }}</small>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('tutor.tareas.edit', $task->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        <form action="{{ route('tutor.tareas.destroy', $task->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar esta tarea?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach


    </ul>
@endif
@endsection
