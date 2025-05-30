@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Justificar falta para {{ $alumno->name }}</h2>

    <form action="{{ route('justificaciones.store') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ $alumno->id }}">

        <div class="mb-3">
            <label for="subject_id">Asignatura</label>
            <select name="subject_id" id="subject_id" class="form-control" required>
                <option value="">Selecciona una asignatura</option>
                @foreach($subjects as $subject)
                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date">Fecha de la falta</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="motivo">Motivo</label>
            <textarea name="motivo" id="motivo" rows="3" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Enviar justificación</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
