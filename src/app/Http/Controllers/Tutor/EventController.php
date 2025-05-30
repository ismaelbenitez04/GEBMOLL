<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Collection;

class EventController extends Controller
{
    public function index()
{
    $tutor = Auth::user();

    // Obtener eventos del tutor o eventos generales para tutores
    $eventos = Event::where('user_id', $tutor->id)
        ->orWhere('role', 'tutor')
        ->get()
        ->map(function ($event) {
            return [
                'title' => $event->title,
                'start' => $event->start_date,
                'end' => $event->end_date,
                'description' => $event->description,
                'color' => '#2ecc71',
            ];
        });

    // Si no hay eventos para el tutor, mostrar un mensaje en lugar de intentar fusionar
    if ($eventos->isEmpty()) {
        return view('calendario.index', ['events' => [], 'message' => 'No hay eventos para este tutor.']);
    }

    // Obtener tareas pendientes de los tutorandos
    $tutorandos = $tutor->tutorandos;
    
    $tareas = collect();  // Iniciamos la colección vacía
    
    foreach ($tutorandos as $alumno) {
        // Obtener tareas pendientes de cada tutorando
        $tareasAlumno = $alumno->tasks()
            ->wherePivot('completed', false)
            ->with('subject')
            ->get()
            ->map(function ($task) use ($alumno) {
                return [
                    'title' => '🧑 ' . $alumno->name . ': ' . $task->description,
                    'start' => $task->due_date,
                    'end' => $task->due_date,
                    'color' => '#f39c12',
                ];
            });

        // Fusionar las tareas del alumno a la colección principal
        $tareas = $tareas->merge($tareasAlumno);
    }

    // Fusionar los eventos con las tareas pendientes
    $events = $eventos->merge($tareas);

    // Retornar la vista con los eventos
    return view('calendario.index', compact('events'));
}

}
