@extends('layouts.user')

@section('content')
<div class="container">
    <h2>Tareas Asignadas</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="d-flex mb-3 gap-2">
        <a href="{{ route('alumno.tareas', ['filtro' => 'pendientes']) }}" class="btn btn-outline-primary {{ request('filtro') === 'pendientes' ? 'active' : '' }}">Tareas Pendientes</a>
        <a href="{{ route('alumno.tareas', ['filtro' => 'completadas']) }}" class="btn btn-outline-success {{ request('filtro') === 'completadas' ? 'active' : '' }}">Tareas Completadas</a>
        <a href="{{ route('alumno.tareas') }}" class="btn btn-outline-secondary {{ is_null(request('filtro')) ? 'active' : '' }}">Todas</a>
    </div>

    @forelse ($tasks as $task)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $task->subject->name }} - {{ $task->due_date }}</h5>
                <p class="card-text">{{ $task->description }}</p>

                @if ($user->tasks->contains($task->id) && $user->tasks->find($task->id)->pivot->completed)
                    <span class="badge bg-success">Completada</span>
                @else
                    <form action="{{ route('alumno.tareas.completar', $task) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary">Marcar como completada</button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <p>No hay tareas asignadas.</p>
    @endforelse
</div>
@endsection
