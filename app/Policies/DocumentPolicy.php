<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->role === 'admin') {
            return true;
        }
    }

    public function reception(User $user)
    {
        foreach ($user->permissions as $permission) {
            if ($permission->name === 'reception')
                return true;
        }
    }
}
