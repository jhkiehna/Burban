<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();
        
        if($user->checkPassword($request->password)) {
            $user->generateApiToken();
            $user->refresh();

            return response($user, 200);
        }

        return response(['error' => 'Invalid email or password'], 401);
    }

    public function logout(Request $request)
    {
        $user = auth()->user();
        $user->generateApiToken();

        return response(null, 204);
    }
}
