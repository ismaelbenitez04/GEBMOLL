<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    // 📋 Mostrar todas las calificaciones que pertenecen a asignaturas del tutor
    public function index()
    {
        $tutor = auth()->user();

        // Obtenemos las asignaturas que enseña el tutor
        $subjects = $tutor->subjects;

        // Filtramos las calificaciones solo de esas asignaturas
        $grades = Grade::whereIn('subject_id', $subjects->pluck('id'))
            ->with(['user', 'subject']) // Cargamos relaciones para mostrar nombre del alumno y la asignatura
            ->get();

        return view('tutor.calificaciones.index', compact('grades'));
    }

    // 📝 Mostrar formulario para crear una nueva calificación
    public function create()
    {
        $tutor = auth()->user();

        // Obtenemos todos los alumnos
        $students = User::where('role', 'alumno')->get();

        // Obtenemos las asignaturas que el tutor puede evaluar
        $subjects = $tutor->subjects;

        return view('tutor.calificaciones.create', compact('students', 'subjects'));
    }

    // 💾 Guardar nueva calificación
    public function store(Request $request)
    {
        // Validación del formulario
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|numeric|min:0|max:10',
            'date' => 'required|date',
        ]);

        $tutor = auth()->user();

        // Seguridad: el tutor solo puede asignar notas a sus propias asignaturas
        if (!$tutor->subjects->contains($request->subject_id)) {
            return redirect()->route('tutor.calificaciones.index')
                ->with('error', 'No tienes permisos para agregar calificación a esta asignatura.');
        }

        // Crear la nota
        Grade::create([
            'user_id' => $request->user_id,
            'subject_id' => $request->subject_id,
            'grade' => $request->grade,
            'date' => $request->date,
        ]);

        return redirect()->route('tutor.calificaciones.index')->with('success', 'Calificación guardada correctamente.');
    }

    // ✏️ Mostrar formulario para editar una calificación existente
    public function edit(Grade $grade)
    {
        $tutor = auth()->user();

        // Verificamos que la calificación pertenezca a una asignatura del tutor
        if (!$tutor->subjects->contains($grade->subject)) {
            return redirect()->route('tutor.calificaciones.index')
                ->with('error', 'No tienes permisos para editar la calificación de esta asignatura.');
        }

        // Obtenemos los alumnos del grupo de la asignatura para que se puedan reasignar si es necesario
        $students = User::where('group_id', $grade->subject->group_id)->get();
        $subjects = $tutor->subjects;

        return view('tutor.calificaciones.edit', compact('grade', 'students', 'subjects'));
    }

    // ♻️ Actualizar calificación
    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'grade' => 'required|numeric|min:0|max:10',
            'date' => 'required|date',
        ]);

        $tutor = auth()->user();

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

    // 🗑️ Eliminar una calificación
    public function destroy(Grade $grade)
    {
        $tutor = auth()->user();

        if (!$tutor->subjects->contains($grade->subject)) {
            return redirect()->route('tutor.calificaciones.index')
                ->with('error', 'No tienes permisos para eliminar la calificación de esta asignatura.');
        }

        $grade->delete();

        return redirect()->route('tutor.calificaciones.index')->with('success', 'Calificación eliminada correctamente.');
    }
}
