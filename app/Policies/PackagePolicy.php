<?php

namespace App\Policies;

use App\Package;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PackagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the project.
     *
     * @param  \App\User  $user
     * @param  \App\Package  $package
     * @return mixed
     */
    public function view(User $user, Package $package)
    {
        // Update $user authorization to view $package here.
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create projects.
     *
     * @param  \App\User  $user
     * @param  \App\Package  $package
     * @return mixed
     */
    public function create(User $user, Package $package)
    {
        // Update $user authorization to create $package here.
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param  \App\User  $user
     * @param  \App\Package  $package
     * @return mixed
     */
    public function update(User $user, Package $package)
    {
        // Update $user authorization to update $package here.
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param  \App\User  $user
     * @param  \App\Package  $package
     * @return mixed
     */
    public function delete(User $user, Package $package)
    {
        // Update $user authorization to delete $package here.
        return $user->isAdmin();
    }

    public function addMember(User $user, Package $package)
    {
        return $user->wallet >= $package->wallet_threshold;
    }
}
