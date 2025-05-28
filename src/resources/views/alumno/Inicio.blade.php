@extends('layouts.user')

@section('title', 'Inicio')

@section('content')
<div class="container">
    <h2>¡Bienvenido, {{ auth()->user()->name }}!</h2>
    <br><br>
    <h2 class="lead">Bienvenido a la plataforma GEBMOLL como <strong>{{ ucfirst(auth()->user()->role) }}</strong>.</h2>
    <div class="row g-4 mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary h-100">
                <div class="card-body">
                    <h5 class="card-title">Próximas Tareas</h5>
                    <p class="card-text"></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success h-100">
                <div class="card-body">
                    <h5 class="card-title">Últimas Calificaciones</h5>
                    <p class="card-text"></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger h-100">
                <div class="card-body">
                    <h5 class="card-title">Amonestaciones</h5>
                    <p class="card-text"></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
