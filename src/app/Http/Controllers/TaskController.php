<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $docente = auth()->user();

        $tasks = \App\Models\Task::whereHas('subject', function ($query) use ($docente) {
            $query->where('teacher_id', $docente->id);
        })->with('subject')->get();

        return view('docente.tareas.index', compact('tasks'));
    }

    public function create()
    {
        $docente = auth()->user();
        $subjects = \App\Models\Subject::where('teacher_id', $docente->id)->get();

        return view('docente.tareas.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'description' => 'required|string',
            'due_date' => 'required|date',
        ]);

        Task::create($request->all());

        return redirect()->route('tareas.index')->with('success', 'Tarea creada correctamente');
    }

}
