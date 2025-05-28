@extends('layouts.user')

@section('content')
<div class="container">
    <h2>Mis Tareas</h2>
    <a href="{{ route('tareas.create') }}" class="btn btn-success mb-3">Crear nueva tarea</a>

    @forelse ($tasks as $task)
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">{{ $task->subject->name }}</h5>
                <p class="card-text">{{ $task->description }}</p>
                <small class="text-muted">Fecha límite: {{ $task->due_date }}</small>
            </div>
        </div>
    @empty
        <p>No hay tareas aún.</p>
    @endforelse
</div>
@endsection
