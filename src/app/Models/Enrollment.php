<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{   // Esta tabla no esta implementada pero es una mejora a añadir
    /**
     * 👤 Relación con el modelo User (alumno)
     * Cada matrícula pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 📚 Relación con el modelo Subject (asignatura)
     * Cada matrícula está asociada a una asignatura concreta.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
