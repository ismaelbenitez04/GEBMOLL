@extends('layouts.admin')

@section('title', 'Crear Alumno')

@section('content')

<form action="{{ route('admin.alumnos.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="group_id" class="form-label">Grupo</label>
        <select name="group_id" id="group_id" class="form-select" required>
            <option value="">Seleccione un grupo</option>
            @foreach($groups as $group)
                <option value="{{ $group->id }}">{{ $group->name }}</option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-primary" type="submit">Crear</button>
</form>
@endsection
