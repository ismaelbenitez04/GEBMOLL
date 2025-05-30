@extends('layouts.admin')

@section('title', 'Notas')

@section('content')

<a href="{{ route('admin.notas.create') }}" class="btn btn-primary mb-3">Agregar Nota</a>

<table class="table table-striped">
<thead>
<tr>
    <th>Alumno</th>
    <th>Asignatura</th>
    <th>Nota</th>
    <th>Fecha</th>
    <th>Acciones</th>
</tr>
</thead>
<tbody>
@foreach ($notas as $nota)
<tr>
    <td>{{ $nota->user->name }}</td>
    <td>{{ $nota->subject->name }}</td>
    <td>{{ $nota->grade }}</td>
    <td>{{ $nota->created_at->format('d/m/Y') }}</td>
    <td>
        <a href="{{ route('admin.notas.edit', $nota->id) }}" class="btn btn-sm btn-primary">Editar</a>
        <form action="{{ route('admin.notas.destroy', $nota->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que quieres eliminar esta nota?')">
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
