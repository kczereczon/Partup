<?php

namespace App\Http\Controllers\Api\V1;

use App\Group;
use App\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function getGroups($id)
    {
        //check if user is in group
        if(true)
        {
            $group = Group::where('id',11);
            return response()->json($group,200);
        }
    }
}
