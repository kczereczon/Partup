<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'group_id'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function newses()
    {
        return $this->hasMany(News::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function homeworks()
    {
        return $this->hasMany(Homework::class);
    }
    public function courseInvitation()
    {
        return $this->hasOne(CourseInvitation::class);
    }
}
