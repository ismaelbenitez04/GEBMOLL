<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    // 🟢 Atributos que se pueden rellenar en masa (por ejemplo, al crear o actualizar)
    protected $fillable = ['name'];

    /**
     * 🔗 Relación uno a muchos: un grupo puede tener muchas asignaturas.
     * Ejemplo de uso: $grupo->subjects
     */
    public function subjects()
    {
        return $this->hasMany(\App\Models\Subject::class);
    }

    /**
     * 🔗 Relación uno a muchos: un grupo puede tener muchos alumnos.
     * Se conecta a la tabla `users` mediante la clave foránea `group_id`.
     * Ejemplo de uso: $grupo->students
     */
    public function students()
    {
        return $this->hasMany(\App\Models\User::class, 'group_id');
    }
}

