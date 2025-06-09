<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // 📅 Mostrar eventos del calendario
    public function index()
    {
        $user = auth()->user(); // Obtener el usuario autenticado

        // Obtener eventos:
        // - que fueron creados por el usuario (personales)
        // - o que están asignados al mismo rol que el usuario (eventos generales por rol)
        $events = Event::where('user_id', $user->id)
            ->orWhere('role', $user->role)
            ->get()
            ->map(function ($event) {
                // Transformamos los datos para usarlos en el calendario
                return [
                    'title' => $event->title,
                    'start' => $event->start_date,
                    'end' => $event->end_date,
                    'description' => $event->description,
                    'color' => '#2ecc71',  // Color verde
                ];
            });

        // Mostrar vista del calendario con los eventos cargados
        return view('calendario.index', compact('events'));
    }

    // 📝 Mostrar formulario para crear nuevo evento
    public function create()
    {
        // Obtener el rol del usuario autenticado
        $role = Auth::user()->role;

        // Solo roles autorizados pueden crear eventos
        if (!in_array($role, ['docente', 'tutor'])) {
            return redirect()->route('calendario.index')->with('error', 'No tienes permisos para crear eventos.');
        }

        // Mostrar el formulario de creación de evento
        return view('calendario.create', compact('role'));
    }

    // 💾 Guardar el evento creado
    public function store(Request $request)
    {
        $role = Auth::user()->role;

        // Validamos los datos enviados desde el formulario
        $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        // Verificamos permisos otra vez por seguridad
        if (!in_array($role, ['docente', 'tutor'])) {
            return redirect()->route('calendario.index')->with('error', 'No tienes permisos para crear eventos.');
        }

        // Creamos el evento en la base de datos
        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'user_id' => Auth::id(), // Asignamos el evento al usuario autenticado
            'role' => $role, // Guardamos el rol para control de visibilidad
        ]);

        // Redirigimos a la ruta según el rol
        if ($role == 'docente') {
            return redirect()->route('calendario.index')->with('success', 'Evento creado correctamente.');
        } elseif ($role == 'tutor') {
            return redirect()->route('tutor.calendario.index')->with('success', 'Evento creado correctamente.');
        }

        // Si el rol no es reconocido, redirigimos a la vista general del calendario
        return redirect()->route('calendario.index');
    }
}
