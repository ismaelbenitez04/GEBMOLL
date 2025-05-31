@extends('layouts.admin')

@section('title', 'Crear Tutor')

@section('content')
<div class="container">
    <h2 class="mb-4 fw-bold">➕ Registrar nuevo Tutor</h2>

    <form action="{{ route('admin.tutores.store') }}" method="POST" class="shadow-sm p-4 bg-white rounded">
        @csrf

        {{-- Nombre --}}
        <div class="mb-3">
            <label for="name" class="form-label">👤 Nombre completo</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Ej: Laura Martínez" required>
        </div>

        {{-- Correo --}}
        <div class="mb-3">
            <label for="email" class="form-label">📧 Correo electrónico</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="ejemplo@colegio.com" required>
        </div>

        {{-- Contraseña --}}
        <div class="mb-3">
            <label for="password" class="form-label">🔑 Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        {{-- Rol (solo 1 opción por ahora) --}}
        <div class="mb-4">
            <label for="role" class="form-label">🔖 Rol del usuario</label>
            <select name="role" id="role" class="form-select" required>
                <option value="tutor" selected>Tutor</option>
            </select>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.tutores.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar Tutor</button>
        </div>
    </form>
</div>
@endsection
