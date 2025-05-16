@extends('layouts.user')

@section('title', 'Tareas')

@section('content')
<p>Bienvenido a la página de tareas para {{ auth()->user()->role }}.</p>
@endsection
