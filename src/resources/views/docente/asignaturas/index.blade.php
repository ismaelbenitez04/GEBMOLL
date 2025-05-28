@extends('layouts.user')

@section('content')
<div class="container">
    <h2 class="mb-4">Mis Asignaturas</h2>

    @if ($subjects->isEmpty())
        <div class="alert alert-info">No tienes asignaturas asignadas.</div>
    @else
        <div class="list-group">
            @foreach ($subjects as $subject)
                <div class="list-group-item">
                    <strong>{{ $subject->name }}</strong>
                    <br>
                    <span class="text-muted">Clase: {{ $subject->group->name ?? 'Sin grupo asignado' }}</span>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
