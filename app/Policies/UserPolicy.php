<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $authUser): bool
    {
        return $authUser->hasPermissionTo('view users') || $authUser->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $authUser, User $model): bool
    {
        return $authUser->hasPermissionTo('view users')
            || $authUser->hasRole('admin')
            || $authUser->id === $model->id; // Boleh lihat profil sendiri
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $auth)
    {
        return $auth->hasAnyRole(['owner', 'admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $authUser, User $targetUser): bool
    {
        return $authUser->hasRole('owner') && $authUser->id !== $targetUser->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $authUser, User $targetUser): bool
    {
        return $authUser->hasRole('owner') && $authUser->id !== $targetUser->id;
    }


    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
