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
        return $this->hasMany(Group::class)->with(['subgroups','groupInvitation','students']);
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

    public function users()
    {
        return $this->belongsToMany(Group::class);
    }

    public function newses()
    {
        return $this->hasMany(News::class);
    }
    public function groupInvitation()
    {
        return $this->hasMany(GroupInvitation::class)->orderBy('accepted', 'desc');
    }
    public function courses()
    {
        return $this->hasMany(Course::class)->with('teacher');
    }
    public function students()
    {
        return $this->hasMany(GroupUser::class)->with('user');
    }
}
