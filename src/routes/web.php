<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SubjectController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Alumno\TaskController as AlumnoTaskController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\JustificacionController;
use App\Http\Controllers\Tutor\GradeController as TutorGradeController;
use App\Http\Controllers\Tutor\TaskController as TutorTaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Perfil (todos los roles)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/mensajes', [MessageController::class, 'index'])->name('mensajes.index');
    Route::get('/mensajes/{user}', [MessageController::class, 'show'])->name('mensajes.show');
    Route::post('/mensajes/{user}', [MessageController::class, 'store'])->name('mensajes.store');
    Route::get('/mensajes/chat/{user}', [MessageController::class, 'show'])->name('mensajes.chat');

    Route::get('/calendario', [EventController::class, 'index'])->name('eventos.index');
    Route::post('/calendario', [EventController::class, 'store'])->name('eventos.store');
    Route::get('/calendario', [EventController::class, 'index'])->name('calendario.index');
});

// ======================= ADMIN =======================
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    });
    Route::resource('tutores', TutorController::class);
});

// ======================= DOCENTE =======================
Route::middleware(['auth', RoleMiddleware::class . ':docente'])->prefix('docente')->group(function () {
    Route::view('/', 'docente.dashboard')->name('docente.dashboard');
    Route::view('/calendario', 'docente.calendario')->name('docente.calendario');
    Route::view('/tareas', 'docente.tareas')->name('docente.tareas');

    Route::get('/inicio', [\App\Http\Controllers\Docente\InicioController::class, 'index'])->name('docente.inicio');
    Route::get('/asignaturas', [SubjectController::class, 'misAsignaturas'])->name('docente.asignaturas');

    Route::resource('calificaciones', GradeController::class)
        ->parameters(['calificaciones' => 'grade'])
        ->names('calificaciones');

    Route::get('/asistencia/clases', [AttendanceController::class, 'seleccionarClase'])->name('asistencia.clases');
    Route::get('/asistencia/pasar-lista/{group}', [AttendanceController::class, 'pasarLista'])->name('asistencia.pasarLista');
    Route::get('/asistencia', [AttendanceController::class, 'index'])->name('asistencia.index');
    Route::get('/asistencia/create', [AttendanceController::class, 'create'])->name('asistencia.create');
    Route::post('/asistencia', [AttendanceController::class, 'store'])->name('asistencia.store');
    Route::get('/asistencia/{attendance}/edit', [AttendanceController::class, 'edit'])->name('asistencia.edit');
    Route::put('/asistencia/{attendance}', [AttendanceController::class, 'update'])->name('asistencia.update');

    Route::get('/tareas', [TaskController::class, 'index'])->name('tareas.index');
    Route::get('/tareas/crear', [TaskController::class, 'create'])->name('tareas.create');
    Route::post('/tareas', [TaskController::class, 'store'])->name('tareas.store');

    Route::get('/calendario', [EventController::class, 'index'])->name('calendario.index');
    Route::post('/calendario', [EventController::class, 'store'])->name('calendario.store');
});

// ======================= ALUMNO =======================
Route::middleware(['auth', RoleMiddleware::class . ':alumno'])
    ->prefix('alumno')
    ->name('alumno.')
    ->group(function () {
        Route::get('/inicio', [\App\Http\Controllers\Alumno\InicioController::class, 'index'])->name('inicio');
        Route::view('/calendario', 'alumno.calendario')->name('calendario');

        Route::get('/asistencia', [AttendanceController::class, 'verAsistenciaAlumno'])->name('asistencia');
        Route::post('/alumno/asistencia/{attendance}/justificar', [AttendanceController::class, 'justificar'])->name('alumno.asistencia.justificar');

        Route::get('/calificaciones', [GradeController::class, 'verCalificacionesAlumno'])->name('calificaciones');

        Route::get('/tareas', [AlumnoTaskController::class, 'index'])->name('tareas');
        Route::post('/tareas/{task}/completar', [AlumnoTaskController::class, 'marcarCompletada'])->name('tareas.completar');

        Route::get('/calendario', [\App\Http\Controllers\Alumno\EventController::class, 'index'])->name('calendario');
});

// ======================= TUTOR =======================
Route::middleware(['auth', RoleMiddleware::class . ':tutor'])
    ->prefix('tutor')
    ->name('tutor.')
    ->group(function () {
        Route::get('/inicio', [\App\Http\Controllers\Tutor\InicioController::class, 'index'])->name('inicio');
        Route::get('/alumnos', [TutorController::class, 'index'])->name('tutorandos');

        Route::get('/calendario', [\App\Http\Controllers\Tutor\EventController::class, 'index'])->name('calendario');

        Route::get('/asistencia', [\App\Http\Controllers\Tutor\AsistenciaController::class, 'index'])->name('asistencia');
        Route::get('/justificaciones', [\App\Http\Controllers\Tutor\JustificacionController::class, 'index'])->name('justificaciones');
        Route::post('/justificaciones/{id}', [\App\Http\Controllers\Tutor\JustificacionController::class, 'update'])->name('justificaciones.update');
        Route::post('/faltas/{alumno}/justificar', [JustificacionController::class, 'justificar'])->name('faltas.justificar');
        Route::get('/justificaciones/create/{alumno}', [JustificacionController::class, 'create'])->name('justificaciones.create');
        Route::post('/justificaciones', [JustificacionController::class, 'store'])->name('justificaciones.store');
        Route::post('/justificaciones/{justificacion}/responder', [TutorController::class, 'responderJustificacion'])->name('justificaciones.responder');

        Route::resource('calificaciones', TutorGradeController::class)
            ->parameters(['calificaciones' => 'grade'])
            ->names('calificaciones');

        Route::get('/calificaciones', [TutorGradeController::class, 'index'])->name('calificaciones.index');
        Route::get('/calificaciones/{grade}/edit', [TutorGradeController::class, 'edit'])->name('calificaciones.edit');
        Route::put('/calificaciones/{grade}', [TutorGradeController::class, 'update'])->name('calificaciones.update');

        Route::get('/tareas', [TutorTaskController::class, 'index'])->name('tareas.index');
        Route::get('/tareas/crear', [TutorTaskController::class, 'create'])->name('tareas.create');
        Route::post('/tareas', [TutorTaskController::class, 'store'])->name('tareas.store');
        Route::get('/tareas/{task}/editar', [TutorTaskController::class, 'edit'])->name('tareas.edit');
        Route::put('/tareas/{task}', [TutorTaskController::class, 'update'])->name('tareas.update');
        Route::delete('/tareas/{task}', [TutorTaskController::class, 'destroy'])->name('tareas.destroy');
    });

require __DIR__.'/auth.php';
