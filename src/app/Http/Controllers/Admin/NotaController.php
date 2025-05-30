<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;

class NotaController extends Controller
{
     public function index()
    {
        // Obtener todas las notas
        $notas = Grade::with('user', 'subject')->get(); // Carga las notas, estudiantes y asignaturas

        return view('admin.notas.index', compact('notas'));
    }
    // Mostrar el formulario para crear una nueva nota
    public function create()
    {
        // Obtén los alumnos y asignaturas disponibles
        $alumnos = User::where('role', 'alumno')->get();
        $asignaturas = Subject::all();

        return view('admin.notas.create', compact('alumnos', 'asignaturas'));
    }

    // Almacenar la nueva nota
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|numeric|min:0|max:10',
        ]);

        // Crear la nueva nota
        Grade::create([
            'user_id' => $request->user_id,
            'subject_id' => $request->subject_id,
            'grade' => $request->grade,
            'date' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.notas.index')->with('success', 'Nota creada correctamente');
    }

     public function edit($id)
    {
        // Obtener la nota a editar
        $nota = Grade::findOrFail($id);

        // Obtener todos los estudiantes y asignaturas
        $alumnos = User::where('role', 'alumno')->get();
        $asignaturas = Subject::all();

        // Retornar la vista con los datos necesarios
        return view('admin.notas.edit', compact('nota', 'alumnos', 'asignaturas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|numeric|min:0|max:10',
        ]);

        // Encontrar la nota por ID
        $nota = Grade::findOrFail($id);

        // Actualizar la nota con los datos del formulario
        $nota->update([
            'user_id' => $request->user_id,
            'subject_id' => $request->subject_id,
            'grade' => $request->grade,
        ]);
        
        return redirect()->route('admin.notas.index')->with('success', 'Nota actualizada correctamente');
    }
      public function destroy($id)
    {
        $nota = Grade::findOrFail($id);
        $nota->delete();

        // Loguear la eliminación
        

        return redirect()->route('admin.notas.index')->with('success', 'Nota eliminada correctamente');
    }
}

