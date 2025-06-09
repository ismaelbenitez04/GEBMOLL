@extends('layouts.user')

@section('title', 'Tareas Asignadas')

@section('content')
<div class="container">
    <div class="mb-4">
        <h1 class="fw-semibold text-primary">Tareas Asignadas</h1>
        <p class="text-muted">Consulta, filtra y marca tus tareas como completadas.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Filtros -->
    <div class="d-flex mb-4 gap-2">
        <a href="{{ route('alumno.tareas', ['filtro' => 'pendientes']) }}"
           class="btn btn-outline-primary {{ request('filtro') === 'pendientes' ? 'active' : '' }}">
            Pendientes
        </a>
        <a href="{{ route('alumno.tareas', ['filtro' => 'completadas']) }}"
           class="btn btn-outline-success {{ request('filtro') === 'completadas' ? 'active' : '' }}">
            Completadas
        </a>
        <a href="{{ route('alumno.tareas') }}"
           class="btn btn-outline-secondary {{ is_null(request('filtro')) ? 'active' : '' }}">
            Todas
        </a>
    </div>

    <!-- Lista de tareas -->
    @forelse ($tasks as $task)
        @php
            $completada = $user->tasks->contains($task->id) && $user->tasks->find($task->id)->pivot->completed;
        @endphp

        <div class="card shadow-sm border-0 rounded-4 mb-3">
            <div class="card-body">
                <h5 class="fw-semibold mb-1">{{ $task->subject->name }}</h5>
                <p class="text-muted mb-2">
                    Entrega: <strong>{{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}</strong>
                </p>
                <p>{{ $task->description }}</p>

                @if ($completada)
                    <span class="badge bg-success">Completada</span>
                @else
                    <form action="{{ route('alumno.tareas.completar', $task) }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-primary">Marcar como completada</button>
                    </form>
                @endif
                 <div class="task-item">
                    <form action="{{ route('alumno.tareas.agregarCalendario', $task->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-warning">Asignar al Calendario</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center text-muted mt-5">
            <p>No hay tareas asignadas.</p>
        </div>
    @endforelse
</div>
@endsection
