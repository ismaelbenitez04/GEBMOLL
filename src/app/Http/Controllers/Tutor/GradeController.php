<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index()
    {
        $tutor = Auth::user();

        // Obtener alumnos tutorados
        $alumnos = User::where('tutor_id', $tutor->id)->pluck('id');

        // Obtener calificaciones de esos alumnos
        $grades = Grade::whereIn('user_id', $alumnos)->with('subject', 'user')->get();

        return view('tutor.calificaciones.index', compact('grades'));
    }

    public function edit(Grade $grade)
    {
        if (!$grade->user || $grade->user->tutor_id !== Auth::id()) {
            abort(403);
        }
        return view('tutor.calificaciones.edit', compact('grade'));
    }

    public function update(Request $request, Grade $grade)
    {
        if ($grade->user->tutor_id !== Auth::id()) {
            abort(403);
        }
        
        $request->validate([
            'grade' => 'required|numeric|min:0|max:10',
        ]);
        
        $grade->update([
            'grade' => $request->grade,
        ]);

        return redirect()->route('tutor.calificaciones.index')->with('success', 'Calificación actualizada correctamente.');
    }
}
