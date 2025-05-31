@extends('layouts.admin')

@section('title', 'Tutores')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">👨‍🏫 Gestión de Tutores</h2>
        <a href="{{ route('admin.tutores.create') }}" class="btn btn-success">➕ Nuevo Tutor</a>
    </div>

    @if($tutores->isEmpty())
        <div class="alert alert-info">
            No hay tutores registrados actualmente.
        </div>
    @else
        <table class="table table-striped table-hover shadow-sm">
            <thead class="table-light">
                <tr>
                    <th>👤 Nombre</th>
                    <th>📧 Email</th>
                    <th class="text-end">⚙️ Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tutores as $tutor)
                    <tr>
                        <td>{{ $tutor->name }}</td>
                        <td>{{ $tutor->email }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.tutores.edit', $tutor->id) }}" class="btn btn-sm btn-warning me-1">✏️ Editar</a>
                            <form action="{{ route('admin.tutores.destroy', $tutor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que quieres eliminar este tutor?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">🗑️ Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
