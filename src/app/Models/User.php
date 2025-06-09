<?php

namespace App\Models;

// Importaciones necesarias para funcionalidades adicionales
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Modelo base para usuarios con autenticación
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable; // Laravel Auditing para logs de auditoría (quién modificó qué)

// 👤 Modelo User, que representa cualquier usuario del sistema: alumno, docente o tutor.
class User extends Authenticatable implements Auditable
{
    // Traits que añaden funcionalidades a la clase
    use \OwenIt\Auditing\Auditable; // Registra cambios en la BD (auditoría)
    use HasFactory, Notifiable;

    /**
     * Campos que se pueden asignar masivamente (formulario, seeders, etc.)
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',       // puede ser: alumno, docente o tutor
        'group_id',   // grupo al que pertenece (si es alumno)
    ];

    /**
     * Campos que estarán ocultos al serializar el modelo (JSON, arrays).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversión de tipos para ciertos atributos.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ───────────────────────────────────────────────
    // RELACIONES SEGÚN EL ROL DEL USUARIO
    // ───────────────────────────────────────────────

    // 📘 Si es un DOCENTE: tiene muchas asignaturas que imparte
    public function subjects()
    {
        return $this->hasMany(Subject::class, 'teacher_id');
    }

    // 🎓 Si es un ALUMNO: se matricula en varias asignaturas (relación con Enrollment)
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // 📊 Si es un ALUMNO: tiene varias notas
    public function grades()
    {
        return $this->hasMany(Grade::class, 'user_id');
    }

    // 🕓 Si es un ALUMNO: asistencias registradas
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // ───────────────────────────────────────────────
    // RELACIONES PARA SISTEMA DE MENSAJERÍA
    // ───────────────────────────────────────────────

    // Mensajes que ha enviado este usuario
    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Mensajes que ha recibido este usuario
    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // ───────────────────────────────────────────────
    // RELACIONES PARA TUTOR / TUTORANDO
    // ───────────────────────────────────────────────

    // Si el usuario es un ALUMNO, pertenece a un TUTOR
    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    // Si el usuario es un TUTOR, tiene varios TUTORANDOS
    public function tutorandos()
    {
        return $this->hasMany(User::class, 'tutor_id');
    }

    // ───────────────────────────────────────────────
    // OTROS
    // ───────────────────────────────────────────────

    // Relación con el grupo al que pertenece (si es alumno)
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    // Relación con tareas asignadas (many-to-many con campo `completed`)
    public function tasks()
    {
        return $this->belongsToMany(Task::class)
                    ->withPivot('completed')
                    ->withTimestamps();
    }

    // Relación con justificaciones de faltas
    public function justificaciones()
    {
        return $this->hasMany(\App\Models\Justificacion::class, 'user_id');
    }
}
