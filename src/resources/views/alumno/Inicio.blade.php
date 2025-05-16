@extends('layouts.user')

@section('title', 'Inicio')

@section('content')
<p>Bienvenido a la página de Inicio para {{ auth()->user()->role }}.</p>
@endsection
