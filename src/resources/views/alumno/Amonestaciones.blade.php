@extends('layouts.user')

@section('title', 'Amonestaciones')

@section('content')
<p>Bienvenido a la página de Amonestaciones para {{ auth()->user()->role }}.</p>
@endsection
