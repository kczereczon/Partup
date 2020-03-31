<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['title','message','group_id','teacher_id'];

    public function course()
    {
        return $this->belongsTo(Group::class);
    }
}
