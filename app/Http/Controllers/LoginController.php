<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();
        
        if($user->checkPassword($request->password)) {
            $user->createApiKey();
            $user->refresh();

            return response($user, 200);
        }

        return response(['error' => 'Invalid email or password'], 401);
    }
}
