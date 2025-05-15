<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
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

}
