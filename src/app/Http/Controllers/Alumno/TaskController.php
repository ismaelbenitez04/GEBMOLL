<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    // Muestra la lista de tareas del alumno
    public function index(Request $request)
    {
        $user = auth()->user(); // Obtenemos el alumno logueado

        // Obtenemos las asignaturas del grupo del alumno
        // (Relacionadas con las tareas que puede ver)
        $groupSubjects = $user->group->subjects->pluck('id');

        // Obtenemos todas las tareas relacionadas con esas asignaturas
        // Las ordenamos por fecha de entrega (ascendente)
        $tareas = Task::with('subject')
            ->whereIn('subject_id', $groupSubjects)
            ->orderBy('due_date', 'asc')
            ->get();

        // Capturamos si viene algún filtro por la URL (por ejemplo, ?filtro=pendientes)
        $filtro = $request->query('filtro');

        // Si el filtro es 'pendientes', eliminamos del listado las tareas que el usuario ya completó
        if ($filtro === 'pendientes') {
            $tareas = $tareas->reject(function ($tarea) use ($user) {
                return $user->tasks->contains($tarea->id) && $user->tasks->find($tarea->id)->pivot->completed;
            });
        }
        // Si el filtro es 'completadas', dejamos solo las tareas que el usuario ha completado
        elseif ($filtro === 'completadas') {
            $tareas = $tareas->filter(function ($tarea) use ($user) {
                return $user->tasks->contains($tarea->id) && $user->tasks->find($tarea->id)->pivot->completed;
            });
        }

        // Devolvemos la vista con las tareas filtradas y el usuario
        return view('alumno.tareas.index', [
            'tasks' => $tareas, 
            'user' => $user,
            'filtro' => $filtro,
        ]);
    }

    // Marca una tarea como completada para el alumno
    public function marcarCompletada(Task $task)
    {
        $user = auth()->user();

        // Asociamos la tarea con el usuario indicando que está completada
        // syncWithoutDetaching mantiene las asociaciones existentes
        $user->tasks()->syncWithoutDetaching([
            $task->id => ['completed' => true]
        ]);

        return back()->with('success', 'Tarea marcada como completada');
    }

    // Añade una tarea al calendario del alumno (es decir, la relaciona como pendiente)
    public function agregarCalendario(Task $task)
    {
        $user = auth()->user();

        // Solo si el alumno no tiene ya la tarea asociada
        if (!$user->tasks->contains($task->id)) {
            // Asociamos la tarea como pendiente (completed = false)
            $user->tasks()->attach($task->id, ['completed' => false]);
        }

        return back()->with('success', 'Tarea añadida al calendario correctamente.');
    }
}
