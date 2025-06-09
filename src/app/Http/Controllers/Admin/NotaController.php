<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    // 📋 Mostrar todas las notas
    public function index()
    {
        // Cargamos todas las notas junto con los datos del alumno y la asignatura relacionada
        $notas = Grade::with('user', 'subject')->get();

        return view('admin.notas.index', compact('notas'));
    }

    // 📝 Mostrar formulario para crear una nueva nota
    public function create()
    {
        // Obtenemos todos los alumnos (rol 'alumno') y todas las asignaturas disponibles
        $alumnos = User::where('role', 'alumno')->get();
        $asignaturas = Subject::all();

        return view('admin.notas.create', compact('alumnos', 'asignaturas'));
    }

    // 💾 Guardar una nueva nota
    public function store(Request $request)
    {
        // Validamos los datos del formulario
        $request->validate([
            'user_id' => 'required|exists:users,id',         // El alumno debe existir
            'subject_id' => 'required|exists:subjects,id',   // La asignatura debe existir
            'grade' => 'required|numeric|min:0|max:10',      // Nota entre 0 y 10
        ]);

        // Creamos la nota con la fecha actual
        Grade::create([
            'user_id' => $request->user_id,
            'subject_id' => $request->subject_id,
            'grade' => $request->grade,
            'date' => now(), // Fecha del sistema
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.notas.index')->with('success', 'Nota creada correctamente');
    }

    // ✏️ Mostrar el formulario de edición de una nota
    public function edit($id)
    {
        // Buscamos la nota por ID
        $nota = Grade::findOrFail($id);

        // Obtenemos alumnos y asignaturas para los selects del formulario
        $alumnos = User::where('role', 'alumno')->get();
        $asignaturas = Subject::all();

        return view('admin.notas.edit', compact('nota', 'alumnos', 'asignaturas'));
    }

    // ♻️ Actualizar una nota existente
    public function update(Request $request, $id)
    {
        // Validamos los datos actualizados
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|numeric|min:0|max:10',
        ]);

        // Buscamos la nota
        $nota = Grade::findOrFail($id);

        // Actualizamos sus campos
        $nota->update([
            'user_id' => $request->user_id,
            'subject_id' => $request->subject_id,
            'grade' => $request->grade,
        ]);

        return redirect()->route('admin.notas.index')->with('success', 'Nota actualizada correctamente');
    }

    // 🗑️ Eliminar una nota
    public function destroy($id)
    {
        // Buscamos y eliminamos la nota
        $nota = Grade::findOrFail($id);
        $nota->delete();

        // Aquí podrías registrar en auditoría que se eliminó una nota (opcional)

        return redirect()->route('admin.notas.index')->with('success', 'Nota eliminada correctamente');
    }
}
