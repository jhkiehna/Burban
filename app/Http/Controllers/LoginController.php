<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();
        
        if($user->checkPassword($request->password)) {
            $user->generateApiToken();
            $user->refresh();

            return new UserResource($user);
        }

        return response(['error' => 'Invalid email or password'], 401);
    }

    public function logout(Request $request)
    {
        auth()->user()->generateApiToken();

        return response(null, 204);
    }
}
