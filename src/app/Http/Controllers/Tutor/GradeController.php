<?php

// app/Http/Controllers/Tutor/GradeController.php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    // Mostrar calificaciones solo de las asignaturas que enseña el tutor
    public function index()
    {
        $tutor = auth()->user();

        // Obtener las asignaturas que imparte el tutor
        $subjects = $tutor->subjects;

        // Obtener las calificaciones solo de las asignaturas del tutor
        $grades = Grade::whereIn('subject_id', $subjects->pluck('id'))
            ->with(['user', 'subject'])  // Relacionar usuario y asignatura
            ->get();

        return view('tutor.calificaciones.index', compact('grades'));
    }

    // Mostrar formulario para crear una nueva calificación
    public function create()
    {
        $tutor = auth()->user();
        $subjects = $tutor->subjects; // Solo las asignaturas del tutor

        return view('tutor.calificaciones.create', compact('subjects'));
    }

    // Guardar una nueva calificación
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|numeric|min:0|max:10',
            'date' => 'required|date',
        ]);

        $tutor = auth()->user();

        // Verificar si la asignatura que se está intentando registrar está asignada al tutor
        if (!$tutor->subjects->contains($request->subject_id)) {
            return redirect()->route('tutor.calificaciones.index')
                ->with('error', 'No tienes permisos para agregar calificación a esta asignatura.');
        }

        Grade::create($request->all());

        return redirect()->route('tutor.calificaciones.index')->with('success', 'Calificación guardada correctamente.');
    }

    // Mostrar formulario de edición de calificación
    public function edit(Grade $grade)
    {
        $tutor = auth()->user();

        // Verificar que el tutor tiene asignada la asignatura de esta calificación
        if (!$tutor->subjects->contains($grade->subject)) {
            return redirect()->route('tutor.calificaciones.index')
                ->with('error', 'No tienes permisos para editar la calificación de esta asignatura.');
        }

        $subjects = $tutor->subjects;

        return view('tutor.calificaciones.edit', compact('grade', 'subjects'));
    }

    // Actualizar la calificación
    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'grade' => 'required|numeric|min:0|max:10',
            'date' => 'required|date',
        ]);

        $tutor = auth()->user();

        // Verificar que el tutor tiene asignada la asignatura de esta calificación
        if (!$tutor->subjects->contains($grade->subject)) {
            return redirect()->route('tutor.calificaciones.index')
                ->with('error', 'No tienes permisos para actualizar la calificación de esta asignatura.');
        }

        $grade->update([
            'grade' => $request->grade,
            'date' => $request->date,
        ]);

        return redirect()->route('tutor.calificaciones.index')->with('success', 'Calificación actualizada correctamente.');
    }

    // Eliminar una calificación
    public function destroy(Grade $grade)
    {
        $tutor = auth()->user();

        // Verificar que el tutor tiene asignada la asignatura de esta calificación
        if (!$tutor->subjects->contains($grade->subject)) {
            return redirect()->route('tutor.calificaciones.index')
                ->with('error', 'No tienes permisos para eliminar la calificación de esta asignatura.');
        }

        $grade->delete();

        return redirect()->route('tutor.calificaciones.index')->with('success', 'Calificación eliminada correctamente.');
    }
}
