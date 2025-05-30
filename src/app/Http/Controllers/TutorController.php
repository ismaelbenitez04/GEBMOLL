<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Justificacion;
class TutorController extends Controller
{
    public function index()
    {
        $tutor = Auth::user();

        // Asegura que el usuario tiene rol de tutor
        if ($tutor->role !== 'tutor') {
            abort(403, 'Acceso denegado.');
        }

        $tutorandos = $tutor->tutorandos; // Usa la relación definida en el modelo User

        return view('tutor.tutorandos', compact('tutorandos'));
    }

    public function revisarJustificaciones()
    {
        $faltas = Attendance::whereHas('user', function ($q) {
            $q->where('tutor_id', Auth::id());
        })->whereNotNull('justification')
        ->where('justification_status', 'pendiente')
        ->with('user', 'subject')
        ->get();

        return view('tutor.justificaciones', compact('faltas'));
    }
    public function responderJustificacion(Request $request, $justificacionId)
    {
        $request->validate([
            'accion' => 'required|in:aceptar,denegar',
        ]);

        $justificacion = Justificacion::findOrFail($justificacionId);

        if ($request->accion === 'aceptar') {
            $justificacion->estado = 'aceptada';
        } else {
            $justificacion->estado = 'rechazada';
        }

        $justificacion->save();

        return redirect()->back()->with('success', 'Respuesta a la justificación guardada correctamente.');
    }


}

