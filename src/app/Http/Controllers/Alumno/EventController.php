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
        $user = Auth::user();

        // Eventos generales o personales
        $eventos = collect(Event::where('user_id', $user->id)
            ->orWhere('role', 'alumno')
            ->get()
            ->map(function ($event) {
                return [
                    'title' => $event->title,
                    'start' => $event->start_date,
                    'end' => $event->end_date,
                    'description' => $event->description,
                    'color' => '#3788d8',
                ];
            })->values());

     $tareas = $user->tasks()
        ->wherePivot('completed', false) // solo tareas pendientes
        ->with('subject')
        ->get()
        ->map(function ($task) {
            return [
                'title' => '📚 ' . $task->subject->name . ': ' . $task->description,
                'start' => $task->due_date,
                'end' => $task->due_date,
                'color' => '#e74c3c',
            ];
        });

        $events = $eventos->merge($tareas)->toArray();

        return view('alumno.calendario.index', compact('events'));
    }
}

