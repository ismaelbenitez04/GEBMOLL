@extends('layouts.user')

@section('title', 'Dashboard Docente')

@section('content')
<p>Bienvenido al panel de docente, {{ auth()->user()->name }}</p>
@endsection
