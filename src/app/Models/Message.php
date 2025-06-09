<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    // 🟢 Campos que se pueden rellenar masivamente
    protected $fillable = ['sender_id', 'receiver_id', 'content'];

    /**
     * 🔗 Relación con el usuario que envía el mensaje
     * Devuelve el objeto User que representa al emisor
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * 🔗 Relación con el usuario que recibe el mensaje
     * Devuelve el objeto User que representa al receptor
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    
    /**
     * ✅ Verifica si el mensaje no ha sido leído
     * Devuelve true si el campo `read_at` es null (mensaje sin leer)
     */
    public function isUnread()
    {
        return is_null($this->read_at);
    }
}



