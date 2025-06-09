<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Task;

class EventController extends Controller
{
    public function index()
    {
        // Obtenemos el usuario autenticado actualmente (el alumno que ha iniciado sesión)
        $user = Auth::user();

        // Recuperamos los eventos:
        // - que son personales del usuario (user_id = ID del usuario actual)
        // - o que están asignados al rol 'alumno' (eventos generales para alumnos)
        // Después transformamos los datos para adaptarlos al formato del calendario
        $eventos = collect(Event::where('user_id', $user->id)
            ->orWhere('role', 'alumno')
            ->get()
            ->map(function ($event) {
                return [
                    'title' => $event->title,          // Título del evento
                    'start' => $event->start_date,     // Fecha de inicio
                    'end' => $event->end_date,         // Fecha de fin
                    'description' => $event->description, // Descripción
                    'color' => '#3788d8',              // Color azul para eventos
                ];
            })->values()); // El método values() reinicia los índices de la colección

        // Recuperamos las tareas del usuario que NO están completadas (pendientes)
        // También cargamos la relación con la asignatura para mostrar su nombre
        $tareas = $user->tasks()
            ->wherePivot('completed', false) // Solo tareas que no están completadas (campo de la tabla intermedia)
            ->with('subject') // Incluimos los datos de la asignatura relacionada
            ->get()
            ->map(function ($task) {
                return [
                    // Mostramos la asignatura y descripción como título
                    'title' => '📚 ' . $task->subject->name . ': ' . $task->description,
                    'start' => $task->due_date, // Fecha límite (inicio)
                    'end' => $task->due_date,   // Fecha límite (fin, mismo día)
                    'color' => '#e74c3c',       // Color rojo para tareas
                ];
            });

        // Combinamos los eventos y las tareas en un solo array
        $events = $eventos->merge($tareas)->toArray();

        // Pasamos los eventos al calendario en la vista del alumno
        return view('alumno.calendario.index', compact('events'));
    }
}
