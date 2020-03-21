<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    protected $fillable = [
        'name',
        'group_id',
        'owner_id',
        'homework_webhook',
        'news_webhook',
        'exam_webhook',
    ];

    public function subgroups(): HasMany
    {
        return $this->hasMany(Group::class)->with('subgroups');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
