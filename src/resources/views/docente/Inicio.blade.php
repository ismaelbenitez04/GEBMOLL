@extends('layouts.user')
@section('title', 'Inicio Docente')

@section('content')
<div class="container">
    <h1 class="fw-semibold text-primary mb-4">Bienvenido/a, {{ Auth::user()->name }}</h1>

    <div class="row g-4">

        <!-- Asistencia pendiente -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white fw-semibold">
                    📝 Tus Clases
                </div>
                <ul class="list-group list-group-flush">
                    @forelse ($subjectsSinAsistencia as $subject)
                        <li class="list-group-item">{{ $subject->name }}</li>
                    @empty
                        <li class="list-group-item text-success">
                            Has pasado lista en todas tus clases 🎉
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Tareas próximas -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white fw-semibold">
                    📚 Tareas con vencimiento cercano
                </div>
                <ul class="list-group list-group-flush">
                    @forelse ($tareasProximas as $tarea)
                        <li class="list-group-item">
                            <strong>{{ $tarea->subject->name }}</strong>: {{ $tarea->description }} <br>
                            <small class="text-muted">Entrega: {{ \Carbon\Carbon::parse($tarea->due_date)->format('d/m/Y') }}</small>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No hay tareas próximas</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Eventos -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white fw-semibold">
                    📅 Eventos próximos
                </div>
                <ul class="list-group list-group-flush">
                    @forelse ($eventos as $evento)
                        <li class="list-group-item">
                            <strong>{{ $evento->title }}</strong> <br>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($evento->start_date)->format('d/m/Y') }}</small>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No hay eventos próximos</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Mensajes -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white fw-semibold">
                    📨 Mensajes recientes
                </div>
                <ul class="list-group list-group-flush">
                    @forelse ($mensajes as $mensaje)
                        <li class="list-group-item">
                            <strong>De:</strong> {{ $mensaje->sender->name }} <br>
                            <small class="text-muted">{{ Str::limit($mensaje->content, 50) }}</small>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No tienes mensajes nuevos</li>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>
</div>
@endsection
