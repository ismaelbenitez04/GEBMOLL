<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'teacher_id',
    ];

    public function teacher()
{
    return $this->belongsTo(User::class, 'teacher_id');
}

public function enrollments()
{
    return $this->hasMany(Enrollment::class);
}

public function grades()
{
    return $this->hasMany(Grade::class);
}

public function attendances()
{
    return $this->hasMany(Attendance::class);
}

public function group()
{
    return $this->belongsTo(\App\Models\Group::class);
}


}
