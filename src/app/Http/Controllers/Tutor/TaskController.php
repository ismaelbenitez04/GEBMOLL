<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // 📋 Mostrar todas las tareas creadas por el tutor
    public function index()
    {
        $tutor = Auth::user();

        // Buscamos todas las tareas que pertenecen a asignaturas del tutor
        $tasks = Task::whereHas('subject', function($query) use ($tutor) {
            $query->where('teacher_id', $tutor->id); // Aseguramos que el tutor sea el profesor de la asignatura
        })->get();

        return view('tutor.tareas.index', compact('tasks'));
    }

    // 📝 Mostrar formulario para crear una nueva tarea
    public function create()
    {
        $tutor = auth()->user();

        // Obtenemos solo las asignaturas que enseña el tutor
        $subjects = $tutor->subjects;

        return view('tutor.tareas.create', compact('subjects'));
    }

    // 💾 Guardar una nueva tarea
    public function store(Request $request)
    {
        // Validamos los datos recibidos
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'description' => 'required|string',
            'due_date' => 'required|date',
        ]);

        // Creamos la tarea asociada a la asignatura
        Task::create([
            'subject_id' => $request->subject_id,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('tutor.tareas.index')->with('success', 'Tarea creada correctamente');
    }

    // ✏️ Mostrar formulario de edición de una tarea
    public function edit(Task $task)
    {
        $tutor = Auth::user();

        // Seguridad: aseguramos que el tutor solo edite tareas de sus asignaturas
        if ($task->subject->teacher_id !== $tutor->id) {
            abort(403); // No autorizado
        }

        $subjects = $tutor->subjects;

        return view('tutor.tareas.edit', compact('task', 'subjects'));
    }

    // 🔁 Actualizar una tarea existente
    public function update(Request $request, Task $task)
    {
        $tutor = Auth::user();

        // Verificación de seguridad como en edit()
        if ($task->subject->teacher_id !== $tutor->id) {
            abort(403);
        }

        // Validación de datos
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'description' => 'required|string',
            'due_date' => 'required|date',
        ]);

        // Actualizamos la tarea
        $task->update($request->all());

        return redirect()->route('tutor.tareas.index')->with('success', 'Tarea actualizada correctamente');
    }

    // 🗑️ Eliminar una tarea
    public function destroy(Task $task)
    {
        $tutor = Auth::user();

        // Verificación de seguridad antes de eliminar
        if ($task->subject->teacher_id !== $tutor->id) {
            abort(403);
        }

        $task->delete();

        return redirect()->route('tutor.tareas.index')->with('success', 'Tarea eliminada correctamente');
    }
}
