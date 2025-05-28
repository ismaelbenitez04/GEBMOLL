@extends('layouts.user')

@section('content')
<div class="container">
    <h2>Enviar mensaje</h2>
    <form action="{{ route('mensajes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="receiver_id" class="form-label">Destinatario</label>
            <select name="receiver_id" class="form-select" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Mensaje</label>
            <textarea name="content" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
@endsection
