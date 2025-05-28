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

    // Vistas generales
    Route::view('/', 'docente.dashboard')->name('docente.dashboard');
    Route::view('/inicio', 'docente.inicio')->name('docente.inicio');
    Route::view('/calendario', 'docente.calendario')->name('docente.calendario');
    Route::view('/amonestaciones', 'docente.amonestaciones')->name('docente.amonestaciones');
    Route::view('/tareas', 'docente.tareas')->name('docente.tareas');
    
    // Asignaturas del docente
    Route::get('/asignaturas', [SubjectController::class, 'misAsignaturas'])->name('docente.asignaturas');

    // Calificaciones
    Route::resource('calificaciones', GradeController::class)
        ->parameters(['calificaciones' => 'grade'])
        ->names('calificaciones');

    // Asistencia
    Route::get('/asistencia/clases', [AttendanceController::class, 'seleccionarClase'])->name('asistencia.clases');
    Route::get('/asistencia/pasar-lista/{group}', [AttendanceController::class, 'pasarLista'])->name('asistencia.pasarLista');
    Route::get('/asistencia', [AttendanceController::class, 'index'])->name('asistencia.index');
    Route::get('/asistencia/create', [AttendanceController::class, 'create'])->name('asistencia.create');
    Route::post('/asistencia', [AttendanceController::class, 'store'])->name('asistencia.store');
    Route::get('/asistencia/{attendance}/edit', [AttendanceController::class, 'edit'])->name('asistencia.edit');
    Route::put('/asistencia/{attendance}', [AttendanceController::class, 'update'])->name('asistencia.update');

    // Tareas
    Route::get('/tareas', [TaskController::class, 'index'])->name('tareas.index');
    Route::get('/tareas/crear', [TaskController::class, 'create'])->name('tareas.create');
    Route::post('/tareas', [TaskController::class, 'store'])->name('tareas.store');
});

// ======================= ALUMNO =======================
Route::middleware(['auth', RoleMiddleware::class . ':alumno'])
    ->prefix('alumno')
    ->name('alumno.')
    ->group(function () {
        Route::view('/', 'alumno.inicio')->name('inicio');
        Route::view('/calendario', 'alumno.calendario')->name('calendario');
        Route::view('/amonestaciones', 'alumno.amonestaciones')->name('amonestaciones');

        // Asistencia
        Route::get('/asistencia', [AttendanceController::class, 'verAsistenciaAlumno'])->name('asistencia');

        // Calificaciones
        Route::get('/calificaciones', [GradeController::class, 'verCalificacionesAlumno'])->name('calificaciones');

        // Tareas
        Route::get('/tareas', [AlumnoTaskController::class, 'index'])->name('tareas');
        Route::post('/tareas/{task}/completar', [AlumnoTaskController::class, 'marcarCompletada'])->name('tareas.completar');
    });

// ======================= TUTOR =======================
Route::middleware(['auth', RoleMiddleware::class . ':tutor'])->prefix('tutor')->group(function () {
    Route::get('/', fn () => view('tutor.dashboard'))->name('tutor.dashboard');
    Route::get('/alumnos', [TutorController::class, 'index'])->name('tutor.tutorandos');
});


require __DIR__.'/auth.php';
