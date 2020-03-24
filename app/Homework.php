<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    protected $fillable = ['name', 'description', 'requirements', 'deadline', 'where_send', 'course_id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
