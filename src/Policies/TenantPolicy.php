<?php

declare(strict_types=1);

namespace Cortex\Tenantable\Policies;

use Rinvex\Fort\Models\User;
use Cortex\Tenantable\Models\Tenant;
use Illuminate\Auth\Access\HandlesAuthorization;

class TenantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list tenants.
     *
     * @param string                   $ability
     * @param \Rinvex\Fort\Models\User $user
     *
     * @return bool
     */
    public function list($ability, User $user)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can create tenants.
     *
     * @param string                   $ability
     * @param \Rinvex\Fort\Models\User $user
     *
     * @return bool
     */
    public function create($ability, User $user)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can update the tenant.
     *
     * @param string                           $ability
     * @param \Rinvex\Fort\Models\User         $user
     * @param \Cortex\Tenantable\Models\Tenant $resource
     *
     * @return bool
     */
    public function update($ability, User $user, Tenant $resource)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can update tenants
    }

    /**
     * Determine whether the user can delete the tenant.
     *
     * @param string                           $ability
     * @param \Rinvex\Fort\Models\User         $user
     * @param \Cortex\Tenantable\Models\Tenant $resource
     *
     * @return bool
     */
    public function delete($ability, User $user, Tenant $resource)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can delete tenants
    }
}
