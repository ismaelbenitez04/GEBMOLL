@extends('layouts.admin')

@section('title', 'Editar Tutor')

@section('content')
<div class="container">
    <h2 class="mb-4 fw-bold">✏️ Editar Tutor</h2>

    <form action="{{ route('admin.tutores.update', $tutor->id) }}" method="POST" class="shadow-sm p-4 bg-white rounded">
        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <div class="mb-3">
            <label for="name" class="form-label">👤 Nombre completo</label>
            <input type="text" name="name" id="name" value="{{ old('name', $tutor->name) }}" class="form-control" required>
        </div>

        {{-- Correo --}}
        <div class="mb-4">
            <label for="email" class="form-label">📧 Correo electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email', $tutor->email) }}" class="form-control" required>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.tutores.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
    </form>
</div>
@endsection
