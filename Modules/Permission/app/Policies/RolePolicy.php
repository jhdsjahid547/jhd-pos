<?php

namespace Modules\Permission\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Access Role');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $role): bool
    {
        return $user->can('Access Role');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('Create Role');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $role): bool
    {
        //if any one want to edit admin to something then prevent
        if ($role->name === 'Admin') {
            return false;
        }

        return $user->can('Edit Role');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $role): bool
    {
        if ($role->name === 'Admin') {
            return false;
        }

        return $user->can('Delete Role');
    }

    /**
     * Determine whether the user can assign permissions to roles.
     */
    public function assignPermissions(User $user, Role $role): bool
    {

        if ($role->name === 'Admin') {
            return false;
        }

        return $user->can('Assign Permission');
    }
}
