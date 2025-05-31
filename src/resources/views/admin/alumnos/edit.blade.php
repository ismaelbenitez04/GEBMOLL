@extends('layouts.admin')

@section('title', 'Editar Alumno')

@section('content')
<div class="container">

    <form action="{{ route('admin.alumnos.update', $alumno->id) }}" method="POST" class="bg-white p-4 rounded shadow-sm">
        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <div class="mb-3">
            <label for="name" class="form-label">📛 Nombre completo</label>
            <input type="text" name="name" id="name" value="{{ old('name', $alumno->name) }}" class="form-control @error('name') is-invalid @enderror" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">📧 Correo Electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email', $alumno->email) }}" class="form-control @error('email') is-invalid @enderror" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Grupo --}}
        <div class="mb-3">
            <label for="group_id" class="form-label">🏫 Grupo</label>
            <select name="group_id" id="group_id" class="form-select @error('group_id') is-invalid @enderror" required>
                <option value="">Seleccione un grupo</option>
                @foreach ($groups as $group)
                    <option value="{{ $group->id }}" {{ $alumno->group_id == $group->id ? 'selected' : '' }}>
                        {{ $group->name }}
                    </option>
                @endforeach
            </select>
            @error('group_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Botones --}}
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-success">💾 Guardar Cambios</button>
            <a href="{{ route('admin.alumnos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
