@extends('layouts.user')

@section('content')
<div class="container">
    <h2>Registrar asistencia para {{ $group->name }}</h2>

    <form method="POST" action="{{ route('asistencia.store') }}">
        @csrf

        {{-- Fecha --}}
        <div class="mb-3">
            <label for="date" class="form-label">Fecha</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        {{-- Asignatura --}}
        <div class="mb-3">
            <label for="subject_id" class="form-label">Asignatura</label>
            <select name="subject_id" class="form-select" required>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Alumnos --}}
        <h4>Alumnos</h4>
        @foreach ($students as $student)
            <div class="mb-3">
                <strong>{{ $student->name }}</strong><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status[{{ $student->id }}]" value="present" required>
                    <label class="form-check-label">Presente</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status[{{ $student->id }}]" value="absent" required>
                    <label class="form-check-label">Ausente</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status[{{ $student->id }}]" value="late" required>
                    <label class="form-check-label">Tarde</label>
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-success mt-3">Guardar asistencia</button>
    </form>
</div>
@endsection
