<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function misAsignaturas()
{
    $docente = auth()->user();

    $subjects = \App\Models\Subject::with('group')
                ->where('teacher_id', $docente->id)
                ->get();

    return view('docente.asignaturas.index', compact('subjects'));
}

}
