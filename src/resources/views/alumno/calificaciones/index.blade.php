@extends('layouts.user')

@section('content')
<div class="container">
    <h2 class="mb-4">Mis Calificaciones</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Asignatura</th>
                <th>Nota</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($grades as $grade)
                <tr>
                    <td>{{ $grade->subject->name ?? '—' }}</td>
                    <td>{{ $grade->grade }}</td>
                    <td>{{ $grade->date }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No hay calificaciones registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
