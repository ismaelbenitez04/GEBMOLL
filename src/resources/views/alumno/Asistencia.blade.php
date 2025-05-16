@extends('layouts.user')

@section('title', 'Asistencia')

@section('content')
<p>Bienvenido a la página de Asistencia para {{ auth()->user()->role }}.</p>
@endsection
