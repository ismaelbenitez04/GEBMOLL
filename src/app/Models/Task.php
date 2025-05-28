<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['subject_id', 'description', 'due_date'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function students()
    {
        return $this->belongsToMany(User::class)->withPivot('completed')->withTimestamps();
    }

}
