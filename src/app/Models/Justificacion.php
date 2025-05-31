<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Justificacion extends Model
{
    use HasFactory;
    protected $table = 'justificaciones';
    protected $fillable = [
        'user_id',
        'subject_id',
        'date',
        'motivo',
        'estado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function subject()
    {
        return $this->belongsTo(\App\Models\Subject::class);
    }

}
