<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Justificacion;

class JustificacionController extends Controller
{
    // 📋 Mostrar todas las justificaciones de los alumnos del tutor
    public function index()
    {
        $justificaciones = Justificacion::with(['user', 'subject']) // Cargamos relaciones con alumno y asignatura
            ->whereHas('user', function ($query) {
                $query->where('tutor_id', auth()->id()); // Solo justificaciones de alumnos del tutor actual
            })
            ->orderBy('date', 'desc') // Orden descendente por fecha
            ->get();

        return view('tutor.justificaciones.index', compact('justificaciones'));
    }

    // ✅ Cambiar el estado de una justificación (aceptada/rechazada)
    public function update(Request $request, $id)
    {
        // Validamos que se haya enviado un estado válido
        $request->validate([
            'estado' => 'required|in:aceptada,rechazada',
        ]);

        $justificacion = Justificacion::findOrFail($id);

        // Solo si la justificación está pendiente se puede modificar
        if ($justificacion->estado === 'pendiente') {
            $justificacion->estado = $request->estado;
            $justificacion->save();
        }

        return redirect()->route('tutor.justificaciones')->with('success', 'Justificación actualizada.');
    }

    // 📌 Método alternativo rápido para justificar una falta (uso interno, sin motivo ni asignatura)
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

    // 📝 Mostrar formulario para registrar una justificación manualmente
    public function create($alumnoId)
    {
        $alumno = User::findOrFail($alumnoId);
        $subjects = Subject::all(); // Aquí puedes filtrar por las del alumno si es necesario

        return view('justificaciones.create', compact('alumno', 'subjects'));
    }

    // 💾 Guardar una nueva justificación desde el formulario
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
            'estado' => 'pendiente', // Se registra como pendiente para revisión
        ]);

        return redirect()->route('justificaciones.index')->with('success', 'Justificación enviada correctamente.');
    }
}
