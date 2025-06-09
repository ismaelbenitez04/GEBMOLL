@extends('layouts.user')

@section('title', 'Crear Evento')

@section('content')
<div class="container">
    <h2 class="mb-4 text-primary fw-semibold">Crear Nuevo Evento Tutor</h2>

    <form action="{{ route('tutor.calendario.store') }}" method="POST" class="bg-white p-4 rounded shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Fecha de inicio</label>
            <input type="datetime-local" name="start_date" id="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">Fecha de finalización</label>
            <input type="datetime-local" name="end_date" id="end_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" id="description" class="form-control" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Crear Evento</button>
    </form>
</div>
@endsection
