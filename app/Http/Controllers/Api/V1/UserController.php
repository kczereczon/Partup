<?php

namespace App\Http\Controllers\Api\V1;

use App\Group;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class UserController extends Controller
{
    public function currentLogged()
    {
        return response()->json(Auth::user(), 200);
    }
}
