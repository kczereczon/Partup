<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    protected $fillable = ['title', 'message', 'group_id', 'teacher_id'];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
