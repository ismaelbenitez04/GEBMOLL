<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    public function user()
{
    return $this->belongsTo(User::class);
}

public function subject()
{
    return $this->belongsTo(Subject::class);
}

}
