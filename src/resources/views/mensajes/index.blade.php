@extends('layouts.user')

@section('content')
<div class="container">
    <h3>Mensajes</h3>
    <br>
    @foreach ($users as $u)
        @php
            $unreadCount = \App\Models\Message::where('sender_id', $u->id)
                            ->where('receiver_id', auth()->id())
                            ->whereNull('read_at')
                            ->count();
        @endphp
        <div class="d-flex justify-content-between align-items-center mb-2">
            <a href="{{ route('mensajes.chat', $u->id) }}" class="text-decoration-none">
                {{ $u->name }}
            </a>
            @if ($unreadCount > 0)
                <span class="badge bg-danger">{{ $unreadCount }} sin leer</span>
            @endif
        </div>
    @endforeach
    </div>
</div>
@endsection
