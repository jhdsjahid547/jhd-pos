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


    public function changeStatus(User $currentUser, User $givenUser): bool
    {
        if ($givenUser->hasRole('Admin')) {
            return false;
        }

        return $currentUser->can('Change Status');
    }
}
