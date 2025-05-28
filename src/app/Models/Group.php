<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name'];

   public function subjects()
    {
        return $this->hasMany(\App\Models\Subject::class);
    }

    public function students()
    {
        return $this->hasMany(\App\Models\User::class, 'group_id'); // Asegúrate que User tiene 'group_id'
    }

}
