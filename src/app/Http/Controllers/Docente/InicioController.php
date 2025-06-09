<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Subject;
use App\Models\Task;
use App\Models\Message;
use App\Models\Attendance;
use Illuminate\Support\Carbon;

class InicioController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Obtenemos el usuario logueado (docente)

        // 1️⃣ Eventos próximos del docente
        $eventos = Event::where('role', 'docente') // Eventos generales para docentes
            ->orWhere('user_id', $user->id)        // O eventos personales del docente
            ->where('start_date', '>=', Carbon::today()) // Solo a partir de hoy
            ->orderBy('start_date')                // Ordenados por fecha
            ->take(5)                              // Solo los primeros 5
            ->get();

        // 2️⃣ Asignaturas del docente sin asistencia pasada hoy
        $hoy = Carbon::today()->toDateString(); // Obtenemos la fecha de hoy en formato YYYY-MM-DD

        $subjectsSinAsistencia = $user->subjects->filter(function ($subject) use ($hoy, $user) {
            // Filtramos las asignaturas donde NO se ha pasado asistencia hoy por este docente
            return !$subject->attendances()
                ->whereDate('date', $hoy)
                ->where('user_id', $user->id)
                ->exists();
        });

        // 3️⃣ Tareas con vencimiento próximo
        $tareasProximas = Task::whereIn('subject_id', $user->subjects->pluck('id')) // Tareas de sus asignaturas
            ->where('due_date', '>=', $hoy)        // Que no han vencido aún
            ->orderBy('due_date')                  // Orden por fecha de vencimiento
            ->take(5)                              // Mostramos las 5 más próximas
            ->get();

        // 4️⃣ Últimos mensajes recibidos por el docente
        $mensajes = $user->messagesReceived()
            ->latest()
            ->take(5)
            ->get();

        // 📊 Enviamos todos estos datos a la vista del dashboard del docente
        return view('docente.inicio', compact('eventos', 'subjectsSinAsistencia', 'tareasProximas', 'mensajes'));
    }
}
