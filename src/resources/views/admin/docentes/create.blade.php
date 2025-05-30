@extends('layouts.admin')

@section('title', 'Crear Docente')

@section('content')

<form action="{{ route('admin.docentes.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Correo Electrónico</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Rol</label>
        <select name="role" id="role" class="form-select" required>
            <option value="docente">Docente</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Crear Docente</button>
</form>

@endsection
