<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupUser extends Pivot
{
    protected $fillable = ['group_id', 'user_id'];
}
