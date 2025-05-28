<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
   public function index(Request $request)
    {
        $user = auth()->user();

        // Obtener todas las tareas del grupo del alumno
        $groupSubjects = $user->group->subjects->pluck('id');

        $tareas = \App\Models\Task::with('subject')
            ->whereIn('subject_id', $groupSubjects)
            ->orderBy('due_date', 'asc')
            ->get();

        // Aplicar filtro si viene por query string
        $filtro = $request->query('filtro');

        if ($filtro === 'pendientes') {
            $tareas = $tareas->reject(function ($tarea) use ($user) {
                return $user->tasks->contains($tarea->id) && $user->tasks->find($tarea->id)->pivot->completed;
            });
        } elseif ($filtro === 'completadas') {
            $tareas = $tareas->filter(function ($tarea) use ($user) {
                return $user->tasks->contains($tarea->id) && $user->tasks->find($tarea->id)->pivot->completed;
            });
        }
        return view('alumno.tareas.index', [
            'tasks' => $tareas, // cambia aquí el nombre de la variable
            'user' => $user,
            'filtro' => $filtro,
        ]);

    }



    public function marcarCompletada(Task $task)
    {
        $user = auth()->user();
        $user->tasks()->syncWithoutDetaching([
            $task->id => ['completed' => true]
        ]);

        return back()->with('success', 'Tarea marcada como completada');
    }
}

