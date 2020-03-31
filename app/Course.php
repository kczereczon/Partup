<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'group_id'];

    public function users()
    {
        return $this->belongsToMany(Users::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
