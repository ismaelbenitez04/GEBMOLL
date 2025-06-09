<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    // 🎯 Permite usar las factories para testing o seeding
    use HasFactory;

    // 🟢 Campos que se pueden rellenar de forma masiva
    protected $fillable = [
        'name',        // Nombre de la asignatura
        'teacher_id',  // ID del docente que imparte esta asignatura
    ];

    /**
     * 🔗 Relación: esta asignatura pertenece a un docente (User)
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * 🔗 Relación: esta asignatura tiene muchas matrículas (enrollments)
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * 🔗 Relación: esta asignatura tiene muchas calificaciones (notas)
     */
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * 🔗 Relación: esta asignatura tiene muchas asistencias registradas
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * 🔗 Relación: esta asignatura pertenece a un grupo concreto
     */
    public function group()
    {
        return $this->belongsTo(\App\Models\Group::class);
    }
}
