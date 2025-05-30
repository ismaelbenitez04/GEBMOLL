@extends('layouts.admin')

@section('title', 'Docentes')

@section('content')

<a href="{{ route('admin.docentes.create') }}" class="btn btn-primary mb-3">Nuevo Docente</a>

<table class="table table-striped">
<thead>
<tr>
    <th>Nombre</th>
    <th>Email</th>
    <th>Acciones</th>
</tr>
</thead>
<tbody>
@foreach ($docentes as $docente)
<tr>
    <td>{{ $docente->name }}</td>
    <td>{{ $docente->email }}</td>
    <td>
        <a href="{{ route('admin.docentes.edit', $docente->id) }}" class="btn btn-sm btn-primary">Editar</a>
        <form action="{{ route('admin.docentes.destroy', $docente->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que quieres eliminar este docente?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
        </form>
    </td>
</tr>
@endforeach
</tbody>
</table>
@endsection
