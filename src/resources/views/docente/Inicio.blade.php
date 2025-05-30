@extends('layouts.user')
@section('title', 'Inicio Docente')

@section('content')
<h1 class="mb-4">Bienvenido/a {{ Auth::user()->name }}</h1>

<div class="row">

    

    <!-- Asistencia pendiente -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">📝 Clases sin asistencia hoy</div>
            <ul class="list-group list-group-flush">
                @forelse ($subjectsSinAsistencia as $subject)
                    <li class="list-group-item">{{ $subject->name }}</li>
                @empty
                    <li class="list-group-item text-success">Has pasado lista en todas tus clases 🎉</li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Tareas próximas -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">📚 Tareas con vencimiento cercano</div>
            <ul class="list-group list-group-flush">
                @forelse ($tareasProximas as $tarea)
                    <li class="list-group-item">
                        {{ $tarea->subject->name }}: {{ $tarea->description }} <br>
                        <small>Entrega: {{ \Carbon\Carbon::parse($tarea->due_date)->format('d/m/Y') }}</small>
                    </li>
                @empty
                    <li class="list-group-item text-muted">No hay tareas próximas</li>
                @endforelse
            </ul>
        </div>
    </div>
    <!-- Eventos -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">📅 Eventos próximos</div>
            <ul class="list-group list-group-flush">
                @forelse ($eventos as $evento)
                    <li class="list-group-item">
                        <strong>{{ $evento->title }}</strong> <br>
                        <small>{{ \Carbon\Carbon::parse($evento->start_date)->format('d/m/Y') }}</small>
                    </li>
                @empty
                    <li class="list-group-item text-muted">No hay eventos próximos</li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Mensajes -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">📨 Mensajes recientes</div>
            <ul class="list-group list-group-flush">
                @forelse ($mensajes as $mensaje)
                    <li class="list-group-item">
                        De: {{ $mensaje->sender->name }} <br>
                        <small>{{ Str::limit($mensaje->content, 50) }}</small>
                    </li>
                @empty
                    <li class="list-group-item text-muted">No tienes mensajes nuevos</li>
                @endforelse
            </ul>
        </div>
    </div>

</div>
@endsection
