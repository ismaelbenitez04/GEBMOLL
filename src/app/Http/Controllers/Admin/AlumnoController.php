<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    // Muestra la lista de alumnos
    public function index()
    {
        // Buscamos todos los usuarios con rol 'alumno'
        $alumnos = User::where('role', 'alumno')->get();

        // Mostramos la vista con todos los alumnos
        return view('admin.alumnos.index', compact('alumnos'));
    }

    // Muestra el formulario para crear un nuevo alumno
    public function create()
    {
        // Recuperamos todos los grupos disponibles para asignarlos al alumno
        $groups = Group::all();  

        // Mostramos la vista del formulario de creación de alumno
        return view('admin.alumnos.create', compact('groups'));
    }

    // Guarda un nuevo alumno en la base de datos
    public function store(Request $request)
    {
        // Validamos los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'group_id' => 'required|exists:groups,id',
        ]);

        // Creamos un nuevo usuario tipo alumno
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->group_id = $request->group_id;
        $user->password = bcrypt('123456'); // Se le asigna una contraseña por defecto
        $user->role = 'alumno'; // Se define el rol como alumno
        $user->save(); // Se guarda en la base de datos

        // Redirige con un mensaje de éxito
        return redirect()->route('admin.alumnos.index')->with('success', 'Alumno creado correctamente');
    }

    // Muestra el formulario para editar un alumno existente
    public function edit($id)
    {
        // Cargamos el alumno por su ID
        $alumno = User::findOrFail($id);

        // Cargamos todos los grupos para que el admin pueda reasignar si quiere
        $groups = Group::all();  

        // Mostramos la vista de edición
        return view('admin.alumnos.edit', compact('alumno', 'groups'));
    }

    // Actualiza los datos de un alumno
    public function update(Request $request, User $alumno)
    {
        // Validamos la información (permitimos que el mismo alumno mantenga su email)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$alumno->id}",
            'group_id' => 'required|exists:groups,id',
        ]);

        // Actualizamos los datos del alumno
        $alumno->update($request->all());

        // Redirige con mensaje de éxito
        return redirect()->route('admin.alumnos.index')->with('success', 'Alumno actualizado.');
    }

    // Elimina un alumno
    public function destroy(User $alumno)
    {
        // Elimina el alumno de la base de datos
        $alumno->delete();

        // Redirige con mensaje de éxito
        return redirect()->route('admin.alumnos.index')->with('success', 'Alumno eliminado.');
    }
}
