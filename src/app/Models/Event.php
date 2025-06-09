<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * Campos que se pueden asignar en masa (mass assignment).
     * Esto permite crear o actualizar eventos con estos atributos fácilmente,
     * por ejemplo: Event::create([...])
     */
    protected $fillable = ['title', 'description', 'start_date', 'end_date', 'user_id', 'role'];

    /**
     * Un evento pertenece a un usuario.
     * Esto permite acceder al usuario que creó el evento desde una instancia del evento:
     * $evento->user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


