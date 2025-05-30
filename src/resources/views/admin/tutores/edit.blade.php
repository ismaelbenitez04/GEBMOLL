@extends('layouts.admin')

@section('title', 'Editar Tutor')

@section('content')
<form action="{{ route('admin.tutores.update', $tutor->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" name="name" id="name" value="{{ old('name', $tutor->name) }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Correo Electrónico</label>
        <input type="email" name="email" id="email" value="{{ old('email', $tutor->email) }}" class="form-control" required>
    </div>


    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>

@endsection
