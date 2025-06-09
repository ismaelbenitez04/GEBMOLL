<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // 📨 Muestra todos los usuarios con los que se puede chatear
    public function index()
    {
        // Obtiene todos los usuarios excepto el actual
        $users = User::where('id', '!=', Auth::id())->get();

        // Muestra la vista con la lista de usuarios
        return view('mensajes.index', compact('users'));
    }

    // 💬 Muestra el chat con un usuario específico
    public function show(User $user)
    {
        $currentUser = auth()->user(); // Usuario autenticado

        // ✅ Marcar como leídos todos los mensajes que:
        // - fueron enviados por $user
        // - fueron recibidos por el usuario actual
        // - aún no han sido leídos
        Message::where('sender_id', $user->id)
            ->where('receiver_id', $currentUser->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        // 🔄 Obtener todos los mensajes entre el usuario actual y el otro usuario
        $messages = Message::where(function ($query) use ($user, $currentUser) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', $currentUser->id);
            })->orWhere(function ($query) use ($user, $currentUser) {
                $query->where('sender_id', $currentUser->id)
                      ->where('receiver_id', $user->id);
            })
            ->orderBy('created_at') // Ordenar por fecha
            ->get();

        // Mostrar la vista del chat con todos los mensajes
        return view('mensajes.chat', compact('messages', 'user'));
    }

    // 📝 Enviar un nuevo mensaje
    public function store(Request $request, User $user)
    {
        // Validar que el contenido del mensaje no esté vacío
        $request->validate([
            'content' => 'required|string'
        ]);

        // Crear el mensaje con el remitente como el usuario autenticado
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'content' => $request->input('content'),
        ]);

        // Redirigir nuevamente al chat
        return redirect()->route('mensajes.show', $user->id);
    }
}
