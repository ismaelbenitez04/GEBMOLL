@extends('layouts.user')

@section('content')
<div class="container">
    <h2>Selecciona una clase</h2>
    <ul class="list-group mt-4">
        @forelse ($clases as $clase)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $clase->name }}
                <a href="{{ route('asistencia.pasarLista', $clase->id) }}" class="btn btn-primary btn-sm">Pasar lista</a>
            </li>
        @empty
            <li class="list-group-item">No tienes clases asignadas.</li>
        @endforelse
    </ul>
</div>
@endsection
