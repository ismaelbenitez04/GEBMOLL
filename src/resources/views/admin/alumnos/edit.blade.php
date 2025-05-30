@extends('layouts.admin')

@section('title', 'Editar Alumno')

@section('content')

<form action="{{ route('admin.alumnos.update', $alumno->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" name="name" id="name" value="{{ old('name', $alumno->name) }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Correo Electrónico</label>
        <input type="email" name="email" id="email" value="{{ old('email', $alumno->email) }}" class="form-control" required>
    </div>

   <div class="mb-3">
        <label for="group_id" class="form-label">Grupo</label>
        <select name="group_id" id="group_id" class="form-select" required>
            <option value="">Seleccione un grupo</option>
            @foreach ($groups as $group)
                <option value="{{ $group->id }}" {{ $alumno->group_id == $group->id ? 'selected' : '' }}>
                    {{ $group->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>
@endsection
