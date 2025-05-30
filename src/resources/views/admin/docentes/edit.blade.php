@extends('layouts.admin')

@section('title', 'Editar Docente')

@section('content')

<form action="{{ route('admin.docentes.update', $docente->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $docente->name) }}" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $docente->email) }}" required>
    </div>

    <button class="btn btn-primary" type="submit">Actualizar</button>
</form>
@endsection
