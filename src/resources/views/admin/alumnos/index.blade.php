@extends('layouts.admin')

@section('title', 'Alumnos')

@section('content')

<a href="{{ route('admin.alumnos.create') }}" class="btn btn-primary mb-3">Nuevo Alumno</a>

<table class="table table-striped">
<thead>
<tr>
    <th>Nombre</th>
    <th>Email</th>
    <th>Grupo</th>
    <th>Acciones</th>
</tr>
</thead>
<tbody>
@foreach ($alumnos as $alumno)
<tr>
    <td>{{ $alumno->name }}</td>
    <td>{{ $alumno->email }}</td>
    <td>{{ $alumno->group->name ?? 'No asignado' }}</td>
    <td>
        <a href="{{ route('admin.alumnos.edit', $alumno->id) }}" class="btn btn-sm btn-primary">Editar</a>
        <form action="{{ route('admin.alumnos.destroy', $alumno->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que quieres eliminar este alumno?')">
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
