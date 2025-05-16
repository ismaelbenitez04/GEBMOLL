@extends('layouts.user')

@section('title', 'Dashboard Alumno')

@section('content')
<p>Bienvenido al panel de alumno, {{ auth()->user()->name }}</p>
@endsection
