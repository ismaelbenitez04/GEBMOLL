<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Collection;

class EventController extends Controller
{
    // 📅 Mostrar el calendario con los eventos del tutor
    public function index()
    {
        $user = auth()->user(); // Obtenemos el tutor autenticado

        // Obtenemos los eventos:
        // - que pertenecen directamente a este tutor (user_id)
        // - o que están dirigidos a su rol (rol = 'tutor')
        $events = Event::where('user_id', $user->id)
            ->orWhere('role', $user->role)
            ->get()
            ->map(function ($event) {
                return [
                    'title' => $event->title,
                    'start' => $event->start_date,
                    'end' => $event->end_date,
                    'description' => $event->description,
                    'color' => '#2ecc71',  // Verde para eventos del tutor
                ];
            });

        // Mostramos los eventos en la vista del calendario
        return view('calendario.index', compact('events'));  
    }

    // 💾 Guardar un nuevo evento creado por el tutor
    public function store(Request $request)
    {
        // Validamos los datos del formulario
        $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        // Creamos el evento con los datos del tutor autenticado
        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'user_id' => Auth::id(),
            'role' => Auth::user()->role, // Se guarda con el rol 'tutor'
        ]);

        return redirect()->route('tutor.calendario.index')->with('success', 'Evento creado correctamente.');    
    }

    // 📝 Mostrar el formulario para crear un nuevo evento
    public function create()
    {
        $tutor = Auth::user();  // Obtenemos el tutor (aunque en este caso no se usa)

        return view('calendario.create');
    }
}
