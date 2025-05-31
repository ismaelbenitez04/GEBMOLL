<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Justificacion;

class JustificacionController extends Controller
{
    public function index()
    {
        $justificaciones = Justificacion::with(['user', 'subject'])
            ->whereHas('user', function ($query) {
                $query->where('tutor_id', auth()->id());
            })
            ->orderBy('date', 'desc')
            ->get();

        return view('tutor.justificaciones.index', compact('justificaciones'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:aceptada,rechazada',
        ]);

        $justificacion = Justificacion::findOrFail($id);

        // Solo permite cambiar si aún no ha sido gestionada
        if ($justificacion->estado === 'pendiente') {
            $justificacion->estado = $request->estado;
            $justificacion->save();
        }

        return redirect()->route('tutor.justificaciones')->with('success', 'Justificación actualizada.');
    }

    public function justificar($alumnoId)
    {
        $alumno = User::findOrFail($alumnoId);


        Justificacion::create([
            'user_id' => $alumno->id,
            'justificada' => true,
            'fecha' => now(),
            'tutor_id' => auth()->id()
        ]);

        return back()->with('success', 'Falta justificada correctamente.');
    }

    public function create($alumnoId)
    {
        $alumno = User::findOrFail($alumnoId);
        $subjects = Subject::all(); 
        
        return view('justificaciones.create', compact('alumno', 'subjects'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'motivo' => 'required|string|max:1000',
        ]);

        Justificacion::create([
            'user_id' => $request->user_id,
            'subject_id' => $request->subject_id,
            'date' => $request->date,
            'motivo' => $request->motivo,
            'estado' => 'pendiente', 
        ]);

        return redirect()->route('justificaciones.index')->with('success', 'Justificación enviada correctamente.');
    }
   


}
