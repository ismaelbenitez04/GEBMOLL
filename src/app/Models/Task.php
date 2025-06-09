<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // 🟢 Campos que se pueden asignar de forma masiva (desde formularios, etc.)
    protected $fillable = ['subject_id', 'description', 'due_date'];

    /**
     * 🔗 Relación: esta tarea pertenece a una asignatura.
     * Esto significa que cada tarea está asociada a una materia concreta.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * 🔗 Relación muchos a muchos con los estudiantes (users).
     * Representa qué estudiantes tienen asignada esta tarea.
     * 
     * ➕ `withPivot('completed')`: accede al estado de completado de la tarea.
     * ➕ `withTimestamps()`: guarda automáticamente created_at y updated_at en la tabla pivot.
     */
    public function students()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('completed')  // Campo adicional en la tabla intermedia
                    ->withTimestamps();       // Registra cuándo fue asignada/modificada
    }
}
