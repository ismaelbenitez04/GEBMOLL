<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Justificacion extends Model
{
    use HasFactory;

    // 🧾 Nombre explícito de la tabla en la base de datos
    protected $table = 'justificaciones';

    // 🟢 Campos que se pueden asignar masivamente
    protected $fillable = [
        'user_id',      // ID del alumno que justifica
        'subject_id',   // ID de la asignatura relacionada
        'date',         // Fecha de la justificación
        'motivo',       // Texto con el motivo de la justificación
        'estado',       // Estado de la justificación: pendiente, aceptada o rechazada
    ];

    /**
     * 🔗 Relación: esta justificación pertenece a un usuario (alumno)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 🔗 Relación: esta justificación está asociada a un registro de asistencia.
     * ⚠️ Puede ser innecesaria si ya estás enlazando la justificación mediante `user_id` y `subject_id`.
     */
    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    /**
     * 🔗 Relación: esta justificación pertenece a una asignatura concreta.
     */
    public function subject()
    {
        return $this->belongsTo(\App\Models\Subject::class);
    }
}
