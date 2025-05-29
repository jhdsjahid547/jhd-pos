<?php

namespace Modules\Permission\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct() {}

    public function viewAny(User $user): bool
    {
        return $user->can('Access Employee');
    }

    public function view(User $currentUser, User $givenUser): bool
    {
        return $currentUser->can('Access Employee');
    }

    public function changeStatus(User $currentUser, User $givenUser): bool
    {
        if ($givenUser->hasRole('Admin')) {
            return false;
        }

        return $currentUser->can('Change Status');
    }

    public function assignRole(User $currentUser, User $givenUser): bool
    {
        if ($givenUser->hasRole('Admin') && $currentUser->id === 1) {
            return false;
        }

        return $currentUser->can('Assign Role');
    }
}
