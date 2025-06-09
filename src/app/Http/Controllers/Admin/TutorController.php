<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class TutorController extends Controller
{
    // 📋 Mostrar todos los tutores
    public function index()
    {
        // Busca todos los usuarios con rol 'tutor'
        $tutores = User::where('role', 'tutor')->get();

        // Muestra la vista con los tutores encontrados
        return view('admin.tutores.index', compact('tutores'));
    }

    // 📝 Mostrar el formulario para crear un nuevo tutor
    public function create()
    {
        return view('admin.tutores.create');
    }

    // 💾 Guardar un nuevo tutor
    public function store(Request $request)
    {
        // Validamos los datos enviados desde el formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:tutor',  // Forzamos que el rol sea 'tutor'
        ]);

        // Creamos el nuevo tutor
        $tutor = new User();
        $tutor->name = $request->name;
        $tutor->email = $request->email;
        $tutor->password = bcrypt($request->password); // Encriptamos la contraseña
        $tutor->role = 'tutor'; // Asignamos el rol directamente
        $tutor->save();

        return redirect()->route('admin.tutores.index')->with('success', 'Tutor creado correctamente');
    }

    // ✏️ Mostrar formulario para editar un tutor
    public function edit(User $tutor)
    {
        return view('admin.tutores.edit', compact('tutor'));
    }

    // ♻️ Actualizar los datos del tutor
    public function update(Request $request, User $tutor)
    {
        // Validamos los nuevos datos (sin repetir emails ya existentes)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$tutor->id}",
        ]);

        // Actualizamos el modelo con los datos del formulario
        $tutor->update($request->all());

        return redirect()->route('admin.tutores.index')->with('success', 'Tutor actualizado.');
    }

    // 🗑️ Eliminar un tutor
    public function destroy(User $tutor)
    {
        $tutor->delete();

        return redirect()->route('admin.tutores.index')->with('success', 'Tutor eliminado correctamente.');
    }
}
