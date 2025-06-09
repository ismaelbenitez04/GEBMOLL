<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    // 🧾 Campos que se pueden asignar masivamente
    protected $fillable = ['user_id', 'subject_id', 'date', 'status', 'present'];

    // 🔄 Conversión automática del campo 'present' a tipo booleano
    protected $casts = [
        'present' => 'boolean',
    ];

    /**
     * 📌 Relación con el modelo User
     * Cada registro de asistencia pertenece a un alumno (usuario).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 📚 Relación con el modelo Subject
     * Cada asistencia pertenece a una asignatura.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * 📄 Relación con el modelo Justificacion
     * Una asistencia puede tener una justificación (1 a 1).
     */
    public function justificacion()
    {
        return $this->hasOne(Justificacion::class);
    }
}
