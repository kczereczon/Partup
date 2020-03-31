<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['name', 'range_of_knowlage', 'description', 'place', 'time', 'course_id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
