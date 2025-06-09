<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

class Grade extends Model implements Auditable
{
    // Habilita el uso de factories para pruebas y se integra con el sistema de auditoría (libreria de los logs)
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    /**
     * 🟢 Lista de atributos que se pueden asignar en masa.
     * Esto es útil para crear o actualizar registros fácilmente.
     */
    protected $fillable = [
        'user_id',     // ID del alumno al que pertenece la nota
        'subject_id',  // ID de la asignatura
        'grade',       // Valor de la calificación
        'date',        // Fecha en la que se registró la nota
    ];

    /**
     * 🔗 Relación: una nota pertenece a un usuario (alumno).
     * Puedes acceder así: $nota->user
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * 🔁 Alias alternativo para "user()", útil si quieres usar $nota->student
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * 🔗 Relación: una nota pertenece a una asignatura.
     * Puedes acceder así: $nota->subject
     */
    public function subject()
    {
        return $this->belongsTo(\App\Models\Subject::class, 'subject_id');
    }
}
