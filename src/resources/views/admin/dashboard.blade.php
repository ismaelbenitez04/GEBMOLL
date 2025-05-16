@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<p>Bienvenido al panel de administrador, {{ auth()->user()->name }}</p>
@endsection
