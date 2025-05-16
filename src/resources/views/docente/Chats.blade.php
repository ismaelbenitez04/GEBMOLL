@extends('layouts.user')

@section('title', 'Chats')

@section('content')
<p>Bienvenido a la página de Chats para {{ auth()->user()->role }}.</p>
@endsection
