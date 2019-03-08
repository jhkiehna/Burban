<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserEmailChangeRequest;
use App\Http\Requests\UserPasswordChangeRequest;
use App\Http\Requests\UserDeleteRequest;

class UserController extends Controller
{
    public function updatePassword(UserPasswordChangeRequest $request)
    {
        $user = auth()->user();
        $this->authorize('update', $user);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return new UserResource($user);
    }

    public function updateEmail(UserEmailChangeRequest $request)
    {
        $user = auth()->user();
        $this->authorize('update', $user);

        $user->update([
            'email' => $request->new_email
        ]);

        return new UserResource($user);
    }

    public function destroy(UserDeleteRequest $request)
    {
        $user = auth()->user();
        $this->authorize('delete', $user);
        $user->api_token = null;
        $user->delete();

        return response(null, 204);
    }
}
