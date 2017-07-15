<?php

namespace App\Policies;

use App\User;
use App\Scan;
use Illuminate\Auth\Access\HandlesAuthorization;

class ScanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the scan.
     *
     * @param  \App\User  $user
     * @param  \App\Scan  $scan
     * @return mixed
     */
    public function view(User $user, Scan $scan)
    {
        //
    }

    /**
     * Determine whether the user can create scans.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the scan.
     *
     * @param  \App\User  $user
     * @param  \App\Scan  $scan
     * @return mixed
     */
    public function update(User $user, Scan $scan)
    {
        //
    }

    /**
     * Determine whether the user can delete the scan.
     *
     * @param  \App\User  $user
     * @param  \App\Scan  $scan
     * @return mixed
     */
    public function delete(User $user, Scan $scan)
    {
        //
    }
}
