<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class InicioController extends Controller
{
    public function index()
    {
        // Obtenemos el usuario actualmente autenticado (el alumno que ha iniciado sesión)
        $user = Auth::user();

        // Obtenemos las tareas pendientes del alumno:
        // - Que NO estén marcadas como completadas (campo 'completed' en la tabla pivote)
        // - Que su fecha de entrega sea HOY o en el futuro (para no mostrar tareas antiguas)
        // - Cargamos también la asignatura asociada (relación 'subject')
        $tareasPendientes = $user->tasks()
            ->wherePivot('completed', false)
            ->whereDate('due_date', '>=', now()) // Fecha de entrega mayor o igual a hoy
            ->with('subject')
            ->get();

        // Obtenemos los mensajes que ha recibido el usuario y que aún NO ha leído
        $mensajesSinLeer = Message::where('receiver_id', $user->id)
            ->whereNull('read_at') // Si 'read_at' es NULL, significa que no ha sido leído
            ->get();

        // Obtenemos las últimas 5 calificaciones del alumno (ordenadas por fecha de creación)
        $calificaciones = $user->grades()->latest()->take(5)->get();

        // Retornamos la vista del panel de inicio del alumno, pasándole los datos recopilados
        return view('alumno.inicio', compact('tareasPendientes', 'mensajesSinLeer', 'calificaciones'));
    }
}
