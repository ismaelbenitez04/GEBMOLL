<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', RoleMiddleware::class.':admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    });
});

Route::middleware(['auth', RoleMiddleware::class.':docente'])->group(function () {
    Route::get('/docente', function () {
        return view('docente.dashboard');
    });
});

Route::middleware(['auth', RoleMiddleware::class.':alumno'])->group(function () {
    Route::get('/alumno', function () {
        return view('alumno.dashboard');
    });
});

Route::middleware(['auth', RoleMiddleware::class . ':docente'])->group(function () {
    Route::get('/inicio', function () { return view('docente.inicio'); });
    Route::get('/calendario', function () { return view('docente.calendario'); });
    Route::get('/asistencia', function () { return view('docente.asistencia'); });
    Route::get('/chats', function () { return view('docente.chats'); });
    Route::get('/calificaciones', function () { return view('docente.calificaciones'); });
    Route::get('/amonestaciones', function () { return view('docente.amonestaciones'); });
    Route::get('/tareas', function () { return view('docente.tareas'); });
});

Route::middleware(['auth', RoleMiddleware::class . ':alumno'])->group(function () {
    Route::get('/inicio', function () { return view('alumno.inicio'); });
    Route::get('/calendario', function () { return view('alumno.calendario'); });
    Route::get('/asistencia', function () { return view('alumno.asistencia'); });
    Route::get('/chats', function () { return view('alumno.chats'); });
    Route::get('/calificaciones', function () { return view('alumno.calificaciones'); });
    Route::get('/amonestaciones', function () { return view('alumno.amonestaciones'); });
    Route::get('/tareas', function () { return view('alumno.tareas'); });
});

require __DIR__.'/auth.php';
