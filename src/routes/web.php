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
use App\Http\Controllers\Tutor\JustificacionController;
use App\Http\Controllers\Tutor\GradeController as TutorGradeController;
use App\Http\Controllers\Tutor\TaskController as TutorTaskController;

// Import Admin Controllers
use App\Http\Controllers\Admin\AlumnoController as AdminAlumnoController;
use App\Http\Controllers\Admin\DocenteController as AdminDocenteController;
use App\Http\Controllers\Admin\TutorController as AdminTutorController;
use App\Http\Controllers\Admin\NotaController as AdminNotaController;
use App\Http\Controllers\Admin\LogController as AdminLogController;

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
Route::middleware(['auth', RoleMiddleware::class . ':admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', function () {
            return view('admin.inicio');
        })->name('inicio');

        Route::post('/add-student', [AdminAlumnoController::class, 'addStudentToGroup'])->name('addStudent');
        Route::post('/remove-student', [AdminAlumnoController::class, 'removeStudentFromGroup'])->name('removeStudent');
        Route::post('/create-teacher-tutor', [AdminDocenteController::class, 'createTeacherOrTutor'])->name('createTeacherOrTutor');
        Route::post('/delete-user', [AdminDocenteController::class, 'deleteUser'])->name('deleteUser');
        Route::post('/move-student', [AdminAlumnoController::class, 'moveStudentToAnotherGroup'])->name('moveStudent');
        Route::post('/assign-grade', [AdminNotaController::class, 'assignGradeToStudent'])->name('assignGrade');
        Route::get('/logs/index', [\App\Http\Controllers\Admin\LogController::class, 'index'])->name('logs.index');

        Route::resource('alumnos', AdminAlumnoController::class);
        Route::resource('docentes', AdminDocenteController::class);
        Route::resource('tutores', AdminTutorController::class)->parameters(['tutores' => 'tutor']);
        Route::resource('notas', AdminNotaController::class);
        Route::get('notas/create', [AdminNotaController::class, 'create'])->name('notas.create');
        Route::post('notas', [AdminNotaController::class, 'store'])->name('notas.store');
        Route::put('notas/{id}', [AdminNotaController::class, 'update'])->name('admin.notas.update');
        Route::get('logs', [AdminLogController::class, 'index'])->name('logs');
        Route::put('/admin/alumnos/{id}', [AdminAlumnoController::class, 'update'])->name('admin.alumnos.update');
    });

// ======================= DOCENTE =======================
Route::middleware(['auth', RoleMiddleware::class . ':docente'])->prefix('docente')->group(function () {
    Route::view('/', 'docente.dashboard')->name('docente.dashboard');
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
    Route::get('/calendario/create', [EventController::class, 'create'])->name('calendario.create');
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
         Route::post('/asistencia/{attendance}/justificar', [AttendanceController::class, 'justificar'])->name('asistencia.justificar');
       

        Route::get('/calificaciones', [GradeController::class, 'verCalificacionesAlumno'])->name('calificaciones');

        Route::get('/tareas', [AlumnoTaskController::class, 'index'])->name('tareas');
        Route::post('/tareas/{task}/completar', [AlumnoTaskController::class, 'marcarCompletada'])->name('tareas.completar');
        Route::post('/tareas/{task}/agregarCalendario', [TaskController::class, 'agregarCalendario'])->name('tareas.agregarCalendario');

        Route::get('/calendario', [\App\Http\Controllers\Alumno\EventController::class, 'index'])->name('calendario');
    });

// ======================= TUTOR =======================
Route::middleware(['auth', RoleMiddleware::class . ':tutor'])
    ->prefix('tutor')
    ->name('tutor.')
    ->group(function () {
        Route::get('/inicio', [\App\Http\Controllers\Tutor\InicioController::class, 'index'])->name('inicio');
        Route::get('/alumnos', [TutorController::class, 'index'])->name('tutorandos');

        Route::get('/calendario', [EventController::class, 'index'])->name('calendario.index');
        Route::get('/calendario/create', [EventController::class, 'create'])->name('calendario.create');
        Route::post('/calendario', [EventController::class, 'store'])->name('calendario.store');
        

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
        Route::post('/calificaciones', [TutorGradeController::class, 'store'])->name('calificaciones.store');

        Route::get('/tareas', [TutorTaskController::class, 'index'])->name('tareas.index');
        Route::get('/tareas/crear', [TutorTaskController::class, 'create'])->name('tareas.create');
        Route::post('/tareas', [TutorTaskController::class, 'store'])->name('tareas.store');
        Route::get('/tareas/{task}/editar', [TutorTaskController::class, 'edit'])->name('tareas.edit');
        Route::put('/tareas/{task}', [TutorTaskController::class, 'update'])->name('tareas.update');
        Route::delete('/tareas/{task}', [TutorTaskController::class, 'destroy'])->name('tareas.destroy');
    });

require __DIR__.'/auth.php';
