@extends('layouts.user')

@section('content')
<div class="container">
    <div class="d-flex justify-content-start mb-3">
        <a href="{{ route('mensajes.index') }}" class="btn btn-outline-primary">
            ← Volver
        </a>
    </div>

    <h4>{{ $user->name }}</h4>

    <div class="border p-3 mb-3" style="height: 700px; overflow-y: scroll; background: #f8f9fa;">
        @foreach ($messages as $message)
            <div class="d-flex {{ $message->sender_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }} mb-2">
                <div class="p-2 rounded {{ $message->sender_id === auth()->id() ? 'bg-primary text-white' : 'bg-light' }}">
                    {{ $message->content }}
                    <div class="small text-muted text-end" style="font-size: 0.75em;">
                        {{ $message->created_at->setTimezone('Europe/Madrid')->format('H:i') }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <form action="{{ route('mensajes.store', $user->id) }}" method="POST" class="d-flex">
        @csrf
        <input type="text" name="content" class="form-control me-2" placeholder="Escribe un mensaje..." required>
        <button type="submit" class="btn btn-success">Enviar</button>
    </form>
</div>
@endsection
