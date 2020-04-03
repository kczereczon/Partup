<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupInvitation extends Model
{
    protected $fillable = ['group_id', 'email', 'invite_hash'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
