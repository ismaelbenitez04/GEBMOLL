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
        $user = Auth::user();

        // 1. Eventos próximos
        $eventos = Event::where('role', 'docente')
            ->orWhere('user_id', $user->id)
            ->where('start_date', '>=', Carbon::today())
            ->orderBy('start_date')
            ->take(5)
            ->get();

        // 2. Asignaturas del docente que hoy no tienen asistencia registrada
        $hoy = Carbon::today()->toDateString();
        $subjectsSinAsistencia = $user->subjects->filter(function ($subject) use ($hoy, $user) {
            return !$subject->attendances()
                ->whereDate('date', $hoy)
                ->where('user_id', $user->id) // Solo asistencias pasadas por este docente
                ->exists();
        });


        // 3. Tareas que vencen pronto
        $tareasProximas = Task::whereIn('subject_id', $user->subjects->pluck('id'))
            ->where('due_date', '>=', $hoy)
            ->orderBy('due_date')
            ->take(5)
            ->get();

        // 4. Últimos mensajes recibidos
        $mensajes = $user->messagesReceived()->latest()->take(5)->get();

        return view('docente.inicio', compact('eventos', 'subjectsSinAsistencia', 'tareasProximas', 'mensajes'));
    }
}
