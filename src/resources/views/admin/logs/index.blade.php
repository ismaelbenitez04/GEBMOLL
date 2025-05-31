@extends('layouts.admin')

@section('title', 'Logs de Auditoría')

@section('content')
<div class="container">
    <h2 class="mb-4">📋 Historial de Cambios</h2>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>👤 Usuario</th>
                <th>🛠 Evento</th>
                <th>📦 Modelo</th>
                <th>📅 Fecha</th>
                <th>🔍 Detalles</th>
            </tr>
        </thead>
        <tbody>
        @forelse($logs as $log)
            <tr>
                <td>{{ $log->user->name ?? 'Sistema' }}</td>
                <td><span class="badge bg-secondary">{{ ucfirst($log->event) }}</span></td>
                <td>{{ class_basename($log->auditable_type) }}</td>
                <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <button class="btn btn-sm btn-outline-info" type="button" data-bs-toggle="collapse" data-bs-target="#details-{{ $log->id }}" aria-expanded="false">
                        Ver cambios
                    </button>
                    <div class="collapse mt-2" id="details-{{ $log->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>🕒 Valores anteriores</strong>
                                <pre class="bg-light p-2 rounded">{{ json_encode($log->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            </div>
                            <div class="col-md-6">
                                <strong>🚀 Nuevos valores</strong>
                                <pre class="bg-light p-2 rounded">{{ json_encode($log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="5" class="text-center text-muted">No hay registros de auditoría.</td>
            </tr>
        @endforelse
         <tfoot>
                <tr>
                    <td colspan="5">
                        <div class="d-flex justify-content-center">
                            {{ $logs->links('pagination::bootstrap-5') }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </tbody>
    </table>
</div>


@endsection
