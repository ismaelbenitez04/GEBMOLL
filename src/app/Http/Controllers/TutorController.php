<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TutorController extends Controller
{
    public function index()
    {
        $tutor = Auth::user();

        // Asegura que el usuario tiene rol de tutor
        if ($tutor->role !== 'tutor') {
            abort(403, 'Acceso denegado.');
        }

        $tutorandos = $tutor->tutorandos; // Usa la relación definida en el modelo User

        return view('tutor.tutorandos', compact('tutorandos'));
    }
}

