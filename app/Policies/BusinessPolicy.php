<?php

namespace App\Policies;

use App\User;
use App\Business;
use Illuminate\Auth\Access\HandlesAuthorization;

class BusinessPolicy
{
    use HandlesAuthorization;

    public function view(?User $user, Business $business)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->business_user;
    }

    public function update(User $user, Business $business)
    {
        return $user->business_user && $user->id === $business->user_id;
    }

    public function delete(User $user, Business $business)
    {
        return $user->business_user && $user->id === $business->user_id;
    }
}
