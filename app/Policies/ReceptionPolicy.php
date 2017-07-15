<?php

namespace App\Policies;

use App\User;
use App\Reception;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReceptionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the reception.
     *
     * @param  \App\User  $user
     * @param  \App\Reception  $reception
     * @return mixed
     */
    public function view(User $user, Reception $reception)
    {
        //
    }

    /**
     * Determine whether the user can create receptions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the reception.
     *
     * @param  \App\User  $user
     * @param  \App\Reception  $reception
     * @return mixed
     */
    public function update(User $user, Reception $reception)
    {
        //
    }

    /**
     * Determine whether the user can delete the reception.
     *
     * @param  \App\User  $user
     * @param  \App\Reception  $reception
     * @return mixed
     */
    public function delete(User $user, Reception $reception)
    {
        //
    }
}
