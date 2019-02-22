<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $user)
    {
        return $user->authenticate(request()->password) && $user->email === request()->email;
    }

    public function restore()
    {
        //
    }

    public function forceDelete()
    {
        //
    }
}
