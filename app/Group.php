<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{

    protected $appends = ['full_name'];

    protected $fillable = [
        'name',
        'group_id',
        'owner_id',
        'homework_webhook',
        'news_webhook',
        'exams_webhook',
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

    public function getFullNameAttribute()
    {
        if ($this->group)
            return "{$this->group->full_name} - {$this->name}";
        else
            return $this->name;
    }
}
