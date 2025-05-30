<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class InicioController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $tareasPendientes = $user->tasks()
            ->wherePivot('completed', false)
            ->whereDate('due_date', '>=', now())
            ->with('subject')
            ->get();

        $mensajesSinLeer = Message::where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->get();

        $calificaciones = $user->grades()->latest()->take(5)->get();

        return view('alumno.inicio', compact('tareasPendientes', 'mensajesSinLeer', 'calificaciones'));
    }
}
