@extends('layouts.admin')

@section('title', 'Alumnos')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">👨‍🎓 Gestión de Alumnos</h2>
        <a href="{{ route('admin.alumnos.create') }}" class="btn btn-success">➕ Nuevo Alumno</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>👤 Nombre</th>
                    <th>📧 Email</th>
                    <th>🏫 Grupo</th>
                    <th style="width: 160px;">⚙️ Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($alumnos as $alumno)
                    <tr>
                        <td>{{ $alumno->name }}</td>
                        <td>{{ $alumno->email }}</td>
                        <td>{{ $alumno->group->name ?? 'No asignado' }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.alumnos.edit', $alumno->id) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                <form action="{{ route('admin.alumnos.destroy', $alumno->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar este alumno?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No hay alumnos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
