<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    protected $fillable = ['title', 'message', 'group_id', 'course_id', 'teacher_id', 'until_when_to_show'];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class,'teacher_id');
    }
}
