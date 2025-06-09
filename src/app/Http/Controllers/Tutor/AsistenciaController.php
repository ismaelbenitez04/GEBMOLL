<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Justificacion;
use App\Models\User;

class AsistenciaController extends Controller
{
    // 📋 Mostrar el resumen de asistencias y justificaciones de los alumnos del tutor
    public function index()
    {
        // Obtenemos el tutor autenticado actualmente
        $tutor = Auth::user();

        // Obtenemos todos los alumnos asignados a este tutor
        // Cargamos también las justificaciones de asistencia con su asignatura relacionada
        $alumnos = User::where('tutor_id', $tutor->id)
            ->with('justificaciones.subject') // Carga las justificaciones y la asignatura asociada
            ->get();

        // Enviamos los datos a la vista del tutor
        return view('tutor.asistencia.index', compact('alumnos'));
    }
}
