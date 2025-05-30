<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tutor = Auth::user();

        // Obtén tareas relacionadas con las asignaturas que el tutor quiere gestionar
        // Por ejemplo, todas las tareas asignadas por el tutor en sus asignaturas
        $tasks = Task::whereHas('subject', function($query) use ($tutor) {
            // Aquí ajusta según relación con asignaturas
            $query->where('teacher_id', $tutor->id);
        })->get();

        return view('tutor.tareas.index', compact('tasks'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'description' => 'required|string',
            'due_date' => 'required|date',
        ]);

        Task::create([
            'subject_id' => $request->subject_id,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('tutor.tareas.index')->with('success', 'Tarea creada correctamente');
    }
    public function create()
    {
        $tutor = auth()->user();
        $subjects = $tutor->subjects; // Asignaturas del tutor
        return view('tutor.tareas.create', compact('subjects'));
    }
 
     public function edit(Task $task)
    {
        $tutor = Auth::user();

        // Comprobar que la tarea pertenece a una asignatura del tutor
        if ($task->subject->teacher_id !== $tutor->id) {
            abort(403);
        }

        $subjects = $tutor->subjects;

        return view('tutor.tareas.edit', compact('task', 'subjects'));
    }

    // Actualizar tarea
    public function update(Request $request, Task $task)
    {
        $tutor = Auth::user();

        if ($task->subject->teacher_id !== $tutor->id) {
            abort(403);
        }

        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'description' => 'required|string',
            'due_date' => 'required|date',
        ]);

        $task->update($request->all());

        return redirect()->route('tutor.tareas.index')->with('success', 'Tarea actualizada correctamente');
    }

    // Eliminar tarea
    public function destroy(Task $task)
    {
        $tutor = Auth::user();

        if ($task->subject->teacher_id !== $tutor->id) {
            abort(403);
        }

        $task->delete();

        return redirect()->route('tutor.tareas.index')->with('success', 'Tarea eliminada correctamente');
    }


}

