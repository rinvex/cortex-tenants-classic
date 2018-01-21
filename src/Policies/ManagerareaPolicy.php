<?php

declare(strict_types=1);

namespace Cortex\Tenants\Policies;

use Rinvex\Fort\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ManagerareaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can access the managerarea.
     *
     * @param string                   $ability
     * @param \Rinvex\Fort\Models\User $user
     *
     * @return bool
     */
    public function access($ability, User $user): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }
}
