@extends('layouts.admin')

@section('title', 'Docentes')

@section('content')
<div class="container">
    <h2 class="mb-4 fw-bold text-primary">👨‍🏫 Gestión de Docentes</h2>

    <a href="{{ route('admin.docentes.create') }}" class="btn btn-success mb-3">
        ➕ Nuevo Docente
    </a>

    @if ($docentes->isEmpty())
        <div class="alert alert-info">No hay docentes registrados.</div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>📛 Nombre</th>
                        <th>📧 Email</th>
                        <th class="text-end">⚙️ Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($docentes as $docente)
                        <tr>
                            <td>{{ $docente->name }}</td>
                            <td>{{ $docente->email }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.docentes.edit', $docente->id) }}" class="btn btn-sm btn-warning me-1">
                                    ✏️ Editar
                                </a>
                                <form action="{{ route('admin.docentes.destroy', $docente->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que quieres eliminar este docente?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">
                                        🗑️ Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
