<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    // ✅ Método para mostrar las asignaturas del docente autenticado
    public function misAsignaturas()
    {
        // Obtener el usuario autenticado (se asume que es un docente)
        $docente = auth()->user();

        // Obtener las asignaturas que imparte este docente, cargando también el grupo al que pertenecen
        $subjects = \App\Models\Subject::with('group') // eager load del grupo relacionado
                    ->where('teacher_id', $docente->id) // solo las del docente actual
                    ->get(); // obtener los resultados

        // Retornar la vista con las asignaturas encontradas
        return view('docente.asignaturas.index', compact('subjects'));
    }
}
