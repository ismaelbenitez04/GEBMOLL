@extends('layouts.admin')

@section('title', 'Tutores')

@section('content')

<a href="{{ route('admin.tutores.create') }}" class="btn btn-primary mb-3">Nuevo Tutor</a>

<table class="table table-striped">
<thead>
<tr>
    <th>Nombre</th>
    <th>Email</th>
    <th>Acciones</th>
</tr>
</thead>
<tbody>
@foreach ($tutores as $tutor)
<tr>
    <td>{{ $tutor->name }}</td>
    <td>{{ $tutor->email }}</td>
    <td>
        <a href="{{ route('admin.tutores.edit', $tutor->id) }}" class="btn btn-sm btn-primary">Editar</a>
        <form action="{{ route('admin.tutores.destroy', $tutor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que quieres eliminar este tutor?')">
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
