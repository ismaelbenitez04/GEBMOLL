<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Grade;
use App\Models\User;
use App\Models\Message;

class InicioController extends Controller
{
    public function index()
    {
        $tutor = Auth::user();

        // Alumnos a su cargo
        $alumnos = $tutor->tutorandos()->with(['grades', 'messagesReceived'])->get();

        // Total de tutorandos
        $totalAlumnos = $alumnos->count();

        // Mensajes sin leer del tutor
        $mensajesPendientes = Message::where('receiver_id', $tutor->id)
            ->whereNull('read_at')
            ->count();

        return view('tutor.inicio', compact('totalAlumnos', 'mensajesPendientes'));
    }
}

