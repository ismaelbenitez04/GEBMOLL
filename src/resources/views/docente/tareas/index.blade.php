@extends('layouts.user')

@section('title', 'Mis Tareas')

@section('content')
<div class="container">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h1 class="fw-semibold text-primary">Mis Tareas</h1>
        <a href="{{ route('tareas.create') }}" class="btn btn-success">+ Nueva tarea</a>
    </div>

    @forelse ($tasks as $task)
        <div class="card shadow-sm border-0 rounded-4 mb-3">
            <div class="card-body">
                <h5 class="fw-semibold mb-2">{{ $task->subject->name }}</h5>
                <p class="mb-1">{{ $task->description }}</p>
                <small class="text-muted">Fecha límite: {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}</small>
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            No hay tareas registradas por el momento.
        </div>
    @endforelse
</div>
@endsection
