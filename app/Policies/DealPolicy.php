<?php

namespace App\Policies;

use App\User;
use App\Deal;
use Illuminate\Auth\Access\HandlesAuthorization;

class DealPolicy
{
    use HandlesAuthorization;

    public function view(?User $user, Deal $deal)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->business()->exists();
    }

    public function update(User $user, Deal $deal)
    {
        return $user->id === $deal->business->user_id;
    }

    public function delete(User $user, Deal $deal)
    {
        return $user->id === $deal->business->user_id;
    }

    public function restore(User $user, Deal $deal)
    {
        //
    }

    public function forceDelete(User $user, Deal $deal)
    {
        //
    }
}
