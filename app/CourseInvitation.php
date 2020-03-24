<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseInvitation extends Model
{
    public function group()
    {
        return $this->hasOne(Group::class);
    }

    public function teacher()
    {
        return $this->hasOne(User::class, 'teacher_id');
    }
}
