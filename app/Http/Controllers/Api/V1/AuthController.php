<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     *  Login controller.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
        );

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Bad credentials'], 422);
        }

        /** @var User $user  */
        $user = Auth::user();

        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json(['user' => $user, 'access_token' => $accessToken], 200);
    }

    public function register(Request $request)
    {
        $input = $request->validate(
            [
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string',
                'name' => 'required|string',
                're_password' => 'required|same:password'
            ]
        );

        $input['password'] = Hash::make($request->get('password'));

        /** @var User|Builder $user */
        $user = new User();
        $user = $user->create($input);

        $accessToken = $user->createToken('auth')->accessToken;
        return ['user' => $user, 'access_token' => $accessToken];
    }
}
