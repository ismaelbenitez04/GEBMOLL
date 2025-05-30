<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    public function index()
    {
        // Listar usuarios con rol docente
        $docentes = User::where('role', 'docente')->get();
        return view('admin.docentes.index', compact('docentes'));
    }

    public function create()
    {
        return view('admin.docentes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:docente',
        ]);

        // Crear el docente
        $docente = new User();
        $docente->name = $request->name;
        $docente->email = $request->email;
        $docente->password = bcrypt($request->password);
        $docente->role = 'docente'; // Asegúrate que el rol es 'docente'
        $docente->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.docentes.index')->with('success', 'Docente creado correctamente.');
    }

    public function edit(User $docente)
    {
        return view('admin.docentes.edit', compact('docente'));
    }

    public function update(Request $request, User $docente)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$docente->id}",
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $docente->name = $request->name;
        $docente->email = $request->email;
        if ($request->password) {
            $docente->password = bcrypt($request->password);
        }
        $docente->save();

        return redirect()->route('admin.docentes.index')->with('success', 'Docente actualizado correctamente.');
    }

    public function destroy(User $docente)
    {
        $docente->delete();
        return redirect()->route('admin.docentes.index')->with('success', 'Docente eliminado correctamente.');
    }
}
