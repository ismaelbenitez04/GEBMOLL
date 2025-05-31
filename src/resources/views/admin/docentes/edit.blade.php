@extends('layouts.admin')

@section('title', 'Editar Docente')

@section('content')
<div class="container">
    <h2 class="mb-4 fw-bold text-warning">✏️ Editar Información del Docente</h2>

    <form action="{{ route('admin.docentes.update', $docente->id) }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">👤 Nombre completo</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                class="form-control" 
                value="{{ old('name', $docente->name) }}" 
                required 
                placeholder="Ej: Juan López">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">📧 Correo electrónico</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                class="form-control" 
                value="{{ old('email', $docente->email) }}" 
                required 
                placeholder="Ej: docente@instituto.com">
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.docentes.index') }}" class="btn btn-secondary">← Cancelar</a>
            <button class="btn btn-primary" type="submit">💾 Guardar cambios</button>
        </div>
    </form>
</div>
@endsection
