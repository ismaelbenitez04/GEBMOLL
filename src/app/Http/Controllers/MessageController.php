<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('mensajes.index', compact('users'));
    }

    public function show(User $user)
    {
        $currentUser = auth()->user();

        // Marcar como leídos
        Message::where('sender_id', $user->id)
            ->where('receiver_id', $currentUser->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        // Mensajes del chat
        $messages = Message::where(function ($query) use ($user, $currentUser) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', $currentUser->id);
        })->orWhere(function ($query) use ($user, $currentUser) {
            $query->where('sender_id', $currentUser->id)
                ->where('receiver_id', $user->id);
        })->orderBy('created_at')->get();

        return view('mensajes.chat', compact('messages', 'user'));
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'content' => $request->input('content'),
        ]);

        return redirect()->route('mensajes.show', $user->id);
    }
    

}
