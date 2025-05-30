<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Justificacion;
use App\Models\User;

class AsistenciaController extends Controller
{
    public function index()
    {
        
       $tutor = Auth::user();

        $alumnos = User::where('tutor_id', $tutor->id)
            ->with('justificaciones.subject')
            ->get();
        return view('tutor.asistencia.index', compact('alumnos'));
    }
   
}
