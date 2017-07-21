<?php

namespace App\Policies;

use App\User;
use App\Document;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReceptionPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->role === 'admin') {
            return true;
        }
    }

    public function scan(User $user)
    {
        foreach ($user->permissions as $permission) {
            if ($permission->name === 'scan')
                return true;
        }
    }

    public function import(User $user)
    {
        foreach ($user->permissions as $permission) {
            if ($permission->name === 'import')
                return true;
        }
    }

    public function affect(User $user)
    {
        if ($user->role === 'admin')
            return true;
    }

    public function clipping(User $user)
    {
        foreach ($user->permissions as $permission) {
            if ($permission->name === 'clipping')
                return true;
        }
    }

    public function export(User $user)
    {
        foreach ($user->permissions as $permission) {
            if ($permission->name === 'export')
                return true;
        }
    }
}