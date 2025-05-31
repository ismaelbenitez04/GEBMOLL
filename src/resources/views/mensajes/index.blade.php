@extends('layouts.user')

@section('title', 'Mensajes')

@section('content')
<div class="container">
    <div class="mb-4">
        <h1 class="fw-semibold text-primary">Mensajes</h1>
        <p class="text-muted">Selecciona un usuario para ver la conversación.</p>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            @forelse ($users as $u)
                @php
                    $unreadCount = \App\Models\Message::where('sender_id', $u->id)
                                    ->where('receiver_id', auth()->id())
                                    ->whereNull('read_at')
                                    ->count();
                @endphp
                <a href="{{ route('mensajes.chat', $u->id) }}" class="d-flex justify-content-between align-items-center text-decoration-none text-dark px-4 py-3 border-bottom">
                    <span class="fw-medium">{{ $u->name }}</span>
                    @if ($unreadCount > 0)
                        <span class="badge bg-danger">{{ $unreadCount }} sin leer</span>
                    @endif
                </a>
            @empty
                <div class="text-center p-4 text-muted">
                    No hay usuarios con los que chatear por ahora.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
