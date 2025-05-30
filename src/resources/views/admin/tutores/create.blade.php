@extends('layouts.admin')

@section('title', 'Crear Tutor')

@section('content')

<form action="{{ route('admin.tutores.store') }}" method="POST">
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
            <option value="tutor">Tutor</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Crear Tutor</button>
</form>

@endsection
