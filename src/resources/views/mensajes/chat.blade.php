@extends('layouts.user')

@section('title', 'Chat con ' . $user->name)

@section('content')
<div class="container">
    <div class="d-flex justify-content-start mb-3">
        <a href="{{ route('mensajes.index') }}" class="btn btn-outline-primary">
            ← Volver
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-semibold text-primary">{{ $user->name }}</h5>
        </div>

        <div class="card-body" style="height: 600px; overflow-y: auto; background-color: #F9FAFB;">
            @foreach ($messages as $message)
                <div class="d-flex {{ $message->sender_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }} mb-2">
                    <div class="px-3 py-2 rounded-3 {{ $message->sender_id === auth()->id() ? 'bg-primary text-white' : 'bg-light' }}" style="max-width: 75%;">
                        {{ $message->content }}
                        <div class="small text-white-50 text-end mt-1" style="font-size: 0.75em;">
                            {{ $message->created_at->setTimezone('Europe/Madrid')->format('H:i') }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card-footer bg-white border-top">
            <form action="{{ route('mensajes.store', $user->id) }}" method="POST" class="d-flex">
                @csrf
                <input type="text" name="content" class="form-control me-2 rounded-pill" placeholder="Escribe un mensaje..." required>
                <button type="submit" class="btn btn-success rounded-pill px-4">Enviar</button>
            </form>
        </div>
    </div>
</div>
@endsection
