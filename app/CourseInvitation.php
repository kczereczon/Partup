<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseInvitation extends Model
{
    protected $fillable = ['course_id', 'email', 'invite_hash'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
