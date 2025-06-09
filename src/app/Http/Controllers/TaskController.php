<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    // ✅ Mostrar todas las tareas creadas por el docente autenticado
    public function index()
    {
        $docente = auth()->user(); // Obtener el docente autenticado

        // Buscar tareas relacionadas con asignaturas del docente
        $tasks = Task::whereHas('subject', function ($query) use ($docente) {
                $query->where('teacher_id', $docente->id); // Filtrar por asignaturas del docente
            })
            ->with('subject') // Cargar también la relación con la asignatura
            ->get();

        // Mostrar la vista con las tareas encontradas
        return view('docente.tareas.index', compact('tasks'));
    }

    // ✅ Mostrar el formulario para crear una nueva tarea
    public function create()
    {
        $docente = auth()->user();

        // Obtener todas las asignaturas del docente para asignar a la tarea
        $subjects = \App\Models\Subject::where('teacher_id', $docente->id)->get();

        // Mostrar formulario con la lista de asignaturas
        return view('docente.tareas.create', compact('subjects'));
    }

    // ✅ Guardar la nueva tarea en la base de datos
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',  // La asignatura debe existir
            'description' => 'required|string',             // Descripción requerida
            'due_date' => 'required|date',                  // Fecha de entrega válida
        ]);

        // Crear la tarea con los datos recibidos
        Task::create($request->all());

        // Redirigir a la lista de tareas con un mensaje de éxito
        return redirect()->route('tareas.index')->with('success', 'Tarea creada correctamente');
    }

    // ✅ Añadir una tarea al calendario del usuario (como tarea pendiente)
    public function agregarCalendario(Task $task)
    {
        $user = auth()->user(); // Obtener el usuario actual (alumno)

        // Verificar si la tarea ya está asociada al usuario
        if (!$user->tasks->contains($task->id)) {
            // Si no lo está, asociarla como "no completada"
            $user->tasks()->attach($task->id, ['completed' => false]);
        }

        // Volver atrás con un mensaje de éxito
        return back()->with('success', 'Tarea añadida al calendario correctamente.');
    }
}
