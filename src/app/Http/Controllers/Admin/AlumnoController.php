<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function index()
    {
        $alumnos = User::where('role', 'alumno')->get();
        return view('admin.alumnos.index', compact('alumnos'));
    }

    public function create()
    {
        $groups = \App\Models\Group::all();  
        return view('admin.alumnos.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'group_id' => 'required|exists:groups,id',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->group_id = $request->group_id;
        $user->password = bcrypt('123456'); // ejemplo
        $user->role = 'alumno'; // o el rol que corresponda
        $user->save();

        return redirect()->route('admin.alumnos.index')->with('success', 'Alumno creado correctamente');
    }

    public function edit($id)
    {
        // Cargar el alumno por ID
        $alumno = User::findOrFail($id);

        // Obtener todos los grupos disponibles
        $groups = Group::all();  // Asegúrate de que estás pasando los grupos correctamente

        // Pasar el alumno y los grupos a la vista
        return view('admin.alumnos.edit', compact('alumno', 'groups'));
    }

    public function update(Request $request, User $alumno)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$alumno->id}",
            'group_id' => 'required|exists:groups,id',
        ]);

        $alumno->update($request->all());

        return redirect()->route('admin.alumnos.index')->with('success', 'Alumno actualizado.');
    }

    public function destroy(User $alumno)
    {
        $alumno->delete();
        return redirect()->route('admin.alumnos.index')->with('success', 'Alumno eliminado.');
    }
}
