@extends('layouts.user')

@section('content')
<div class="container">
    <h2 class="mb-4">Registrar Asistencia</h2>

    <form action="{{ route('asistencia.store') }}" method="POST">
         @csrf

        {{-- Fecha --}}
        <div class="mb-3">
            <label for="date" class="form-label">Fecha</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        {{-- Clase y Asignatura --}}
        <div class="mb-3">
            <label for="subject_id" class="form-label">Asignatura por clase</label>
            <select name="subject_id" class="form-select" required>
                @foreach ($groups as $group)
                    <optgroup label="{{ $group->name }}">
                        @foreach ($group->subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>

        {{-- Alumnos --}}
        <h4 class="mt-4">Alumnos</h4>
        @foreach ($students as $student)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="present[{{ $student->id }}]" value="1" id="student{{ $student->id }}">
                <label class="form-check-label" for="student{{ $student->id }}">
                    {{ $student->name }}
                </label>
            </div>
        @endforeach

        <button type="submit" class="btn btn-success mt-3">Guardar asistencia</button>
        <a href="{{ route('asistencia.index') }}" class="btn btn-secondary mt-3">Volver</a>
    </form>
</div>
@endsection
