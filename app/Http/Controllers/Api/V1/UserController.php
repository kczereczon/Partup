<?php

namespace App\Http\Controllers\Api\V1;

use App\Group;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function getGroups()
    {
        $group = Auth::user()->groups;
        return response()->json($group,200);
    }
}
