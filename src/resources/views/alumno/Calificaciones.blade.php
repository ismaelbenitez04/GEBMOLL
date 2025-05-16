@extends('layouts.user')

@section('title', 'Calificaciones')

@section('content')
<p>Bienvenido a la página de Calificaiones para {{ auth()->user()->role }}.</p>
@endsection
