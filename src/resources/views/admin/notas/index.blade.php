@extends('layouts.admin')

@section('title', 'Notas')

@section('content')
<div class="container">
    <h2 class="mb-4 fw-bold">📊 Gestión de Notas</h2>

    <a href="{{ route('admin.notas.create') }}" class="btn btn-success mb-3">➕ Agregar Nota</a>

    @if ($notas->isEmpty())
        <div class="alert alert-info">No hay notas registradas.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>👨‍🎓 Alumno</th>
                        <th>📚 Asignatura</th>
                        <th>📈 Nota</th>
                        <th>📅 Fecha</th>
                        <th class="text-end">⚙️ Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notas as $nota)
                        <tr>
                            <td>{{ $nota->user->name }}</td>
                            <td>{{ $nota->subject->name }}</td>
                            <td><span class="badge bg-{{ $nota->grade >= 5 ? 'success' : 'danger' }}">{{ $nota->grade }}</span></td>
                            <td>{{ $nota->created_at->format('d/m/Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.notas.edit', $nota->id) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                <form action="{{ route('admin.notas.destroy', $nota->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que quieres eliminar esta nota?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
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
