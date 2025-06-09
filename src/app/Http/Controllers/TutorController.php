<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Justificacion;

class TutorController extends Controller
{
    // ✅ Muestra la lista de alumnos asignados al tutor
    public function index()
    {
        $tutor = Auth::user(); // Obtener el usuario autenticado

        // Verificar que el usuario tenga rol de tutor
        if ($tutor->role !== 'tutor') {
            abort(403, 'Acceso denegado.'); // Si no lo es, lanzar error 403
        }

        // Obtener los alumnos que tiene asignados como tutor (relación definida en el modelo User)
        $tutorandos = $tutor->tutorandos;

        // Mostrar la vista con los tutorandos
        return view('tutor.tutorandos', compact('tutorandos'));
    }

    // ⚠️ Este método tiene un pequeño fallo: falta importar el modelo Attendance arriba
    public function revisarJustificaciones()
    {
        // Buscar asistencias con justificaciones pendientes de alumnos del tutor
        $faltas = Attendance::whereHas('user', function ($q) {
                $q->where('tutor_id', Auth::id()); // Solo alumnos del tutor actual
            })
            ->whereNotNull('justification') // La asistencia tiene justificación asociada
            ->where('justification_status', 'pendiente') // Que aún no ha sido revisada
            ->with('user', 'subject') // Cargar relaciones necesarias
            ->get();

        // Mostrar la vista con las justificaciones pendientes
        return view('tutor.justificaciones', compact('faltas'));
    }

    // ✅ Permite aceptar o rechazar una justificación
    public function responderJustificacion(Request $request, $justificacionId)
    {
        // Validar la acción recibida
        $request->validate([
            'accion' => 'required|in:aceptar,denegar',
        ]);

        // Buscar la justificación
        $justificacion = Justificacion::findOrFail($justificacionId);

        // Actualizar el estado según la acción seleccionada
        if ($request->accion === 'aceptar') {
            $justificacion->estado = 'aceptada';
        } else {
            $justificacion->estado = 'rechazada';
        }

        // Guardar cambios en la base de datos
        $justificacion->save();

        // Volver atrás con mensaje
        return redirect()->back()->with('success', 'Respuesta a la justificación guardada correctamente.');
    }
}
