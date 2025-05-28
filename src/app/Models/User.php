<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // Si es un profe:
    public function subjects()
    {
        return $this->hasMany(Subject::class, 'teacher_id');
    }

    // Si es un alumno:
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'user_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // Mensajes enviados y recibidos
    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
    // Si el usuario es un alumno, esta es la relación con su tutor
    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    // Si el usuario es un tutor, esta es la relación con sus tutorandos
    public function tutorandos()
    {
        return $this->hasMany(User::class, 'tutor_id');
    }
     public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function tasks()
    {
        return $this->belongsToMany(Task::class)->withPivot('completed')->withTimestamps();
    }



}
