@extends('layouts.admin')

@section('title', 'Crear Docente')

@section('content')
<div class="container">
    <h2 class="mb-4 fw-bold text-primary">➕ Registrar Nuevo Docente</h2>

    <form action="{{ route('admin.docentes.store') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">👤 Nombre completo</label>
            <input type="text" name="name" id="name" class="form-control" required placeholder="Ej: María García">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">📧 Correo Electrónico</label>
            <input type="email" name="email" id="email" class="form-control" required placeholder="Ej: docente@centro.com">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">🔑 Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">🎓 Rol</label>
            <select name="role" id="role" class="form-select" required>
                <option value="docente">Docente</option>
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.docentes.index') }}" class="btn btn-secondary">← Cancelar</a>
            <button type="submit" class="btn btn-success">💾 Crear Docente</button>
        </div>
    </form>
</div>
@endsection
