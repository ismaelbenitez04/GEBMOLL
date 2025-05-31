@extends('layouts.admin')

@section('title', 'Crear Alumno')

@section('content')
<div class="container">
    <h2 class="mb-4 text-primary fw-bold">👤 Crear Nuevo Alumno</h2>

    <form action="{{ route('admin.alumnos.store') }}" method="POST" class="bg-white p-4 rounded shadow-sm">
        @csrf

        {{-- Nombre --}}
        <div class="mb-3">
            <label for="name" class="form-label">📛 Nombre completo</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">📧 Correo electrónico</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Grupo --}}
        <div class="mb-3">
            <label for="group_id" class="form-label">🏫 Grupo asignado</label>
            <select name="group_id" id="group_id" class="form-select @error('group_id') is-invalid @enderror" required>
                <option value="">Seleccione un grupo</option>
                @foreach($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
            @error('group_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Botones --}}
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-success">💾 Crear Alumno</button>
            <a href="{{ route('admin.alumnos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
