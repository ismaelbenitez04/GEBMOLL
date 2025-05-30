@extends('layouts.admin')

@section('title', 'Logs de Auditoría')

@section('content')

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Evento</th>
            <th>Modelo</th>
            <th>Fecha</th>
            <th>Detalles</th>
        </tr>
    </thead>
    <tbody>
    @foreach($logs as $log)
        <tr>
            <td>{{ $log->id }}</td>
            <td>{{ $log->user->name ?? 'Sistema' }}</td>
            <td>{{ $log->event }}</td>
            <td>{{ $log->auditable_type }}</td>
            <td>{{ $log->created_at }}</td>
            <td>
                <button class="btn btn-sm btn-info" type="button" data-bs-toggle="collapse" data-bs-target="#details-{{ $log->id }}" aria-expanded="false" aria-controls="details-{{ $log->id }}">
                    Ver
                </button>
                <div class="collapse mt-2" id="details-{{ $log->id }}">
                    <pre>{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
                    <pre>{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $logs->links() }}

@endsection
