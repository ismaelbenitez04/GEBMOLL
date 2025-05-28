<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    // Listar calificaciones creadas por el docente
    public function index()
    {
        $docente = auth()->user();

        // Obtener IDs de asignaturas del docente
        $subjectIds = $docente->subjects()->pluck('id');

        // Cargar calificaciones solo de sus asignaturas
        $grades = \App\Models\Grade::whereIn('subject_id', $subjectIds)
            ->with(['student', 'subject'])
            ->get();
       
        return view('docente.calificaciones.index', compact('grades'));
    }



    // Mostrar formulario de creación
    public function create()
    {
        $students = User::where('role', 'alumno')->get();
        $subjects = Auth::user()->subjects;

        return view('docente.calificaciones.create', compact('students', 'subjects'));
    }

    public function edit(Grade $grade)
    {
        $students = \App\Models\User::where('role', 'alumno')->get();
        $subjects = auth()->user()->subjects;

        return view('docente.calificaciones.edit', [
            'grade' => $grade,
            'students' => $students,
            'subjects' => $subjects,
        ]);
    }


    public function update(Request $request, \App\Models\Grade $grade)
    {
        $request->validate([
            'grade' => 'required|numeric|min:0|max:10',
            'date' => 'required|date',
        ]);

        $grade->update([
            'grade' => $request->grade,
            'date' => $request->date,
        ]);

        return redirect()->route('calificaciones.index')->with('success', 'Calificación actualizada correctamente.');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();

        return redirect()->route('calificaciones.index')->with('success', 'Calificación eliminada correctamente.');
    }


    // Guardar nueva calificación
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|numeric|min:0|max:10',
            'date' => 'required|date',
        ]);

        Grade::create($request->all());

        return redirect()->route('calificaciones.index')->with('success', 'Calificación guardada correctamente.');
    }
    public function verCalificacionesAlumno()
    {
        $user = auth()->user();

        $grades = \App\Models\Grade::where('user_id', $user->id)
                    ->with('subject')
                    ->get();

        return view('alumno.calificaciones.index', compact('grades'));
    }

}
