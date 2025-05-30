<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class TutorController extends Controller
{
    public function index()
    {
        $tutores = User::where('role', 'tutor')->get();
        return view('admin.tutores.index', compact('tutores'));
    }

    public function create()
    {
        return view('admin.tutores.create');
    }

     public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:tutor',  // Especificar que el rol es tutor
        ]);

        // Crear el tutor
        $tutor = new User();
        $tutor->name = $request->name;
        $tutor->email = $request->email;
        $tutor->password = bcrypt($request->password);
        $tutor->role = 'tutor'; 
        $tutor->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.tutores.index')->with('success', 'Tutor creado correctamente');
    }

    public function edit(User $tutor)
    {
        return view('admin.tutores.edit', compact('tutor'));
    }

    public function update(Request $request, User $tutor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$tutor->id}",
        ]);

        $tutor->update($request->all());

        return redirect()->route('admin.tutores.index')->with('success', 'Tutor actualizado.');
    }

    public function destroy(User $tutor)
    {
        $tutor->delete();
        return redirect()->route('admin.tutores.index')->with('success', 'Tutor eliminado correctamente.');
    }
}
