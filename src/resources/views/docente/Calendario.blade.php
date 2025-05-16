@extends('layouts.user')

@section('title', 'Calendario')

@section('content')
<p>Bienvenido a la página del Calendario para {{ auth()->user()->role }}.</p>
@endsection
