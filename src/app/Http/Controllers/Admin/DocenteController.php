<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    // 🧾 Listar todos los docentes
    public function index()
    {
        // Busca todos los usuarios cuyo rol sea "docente"
        $docentes = User::where('role', 'docente')->get();

        // Retorna la vista con la lista de docentes
        return view('admin.docentes.index', compact('docentes'));
    }

    // 📝 Mostrar formulario de creación de docente
    public function create()
    {
        // Retorna la vista con el formulario para crear un docente
        return view('admin.docentes.create');
    }

    // 💾 Guardar un nuevo docente en la base de datos
    public function store(Request $request)
    {
        // Validamos los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:docente', // Aseguramos que el rol sea "docente"
        ]);

        // Creamos y guardamos el docente
        $docente = new User();
        $docente->name = $request->name;
        $docente->email = $request->email;
        $docente->password = bcrypt($request->password); // Encriptamos la contraseña
        $docente->role = 'docente'; // Asignamos el rol
        $docente->save();

        // Redirigimos con mensaje de éxito
        return redirect()->route('admin.docentes.index')->with('success', 'Docente creado correctamente.');
    }

    // ✏️ Mostrar formulario para editar un docente
    public function edit(User $docente)
    {
        // Mostramos la vista con los datos del docente
        return view('admin.docentes.edit', compact('docente'));
    }

    // ♻️ Actualizar los datos del docente
    public function update(Request $request, User $docente)
    {
        // Validamos los datos (la contraseña es opcional)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$docente->id}",
            'password' => 'nullable|string|min:6|confirmed', // Si se escribe, debe ser confirmada
        ]);

        // Actualizamos los campos
        $docente->name = $request->name;
        $docente->email = $request->email;

        // Solo actualizamos la contraseña si se envió una nueva
        if ($request->password) {
            $docente->password = bcrypt($request->password);
        }

        $docente->save();

        // Redirigimos con mensaje de éxito
        return redirect()->route('admin.docentes.index')->with('success', 'Docente actualizado correctamente.');
    }

    // 🗑️ Eliminar un docente
    public function destroy(User $docente)
    {
        $docente->delete();

        return redirect()->route('admin.docentes.index')->with('success', 'Docente eliminado correctamente.');
    }
}
