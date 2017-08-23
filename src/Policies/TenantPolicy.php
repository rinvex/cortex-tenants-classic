<?php

declare(strict_types=1);

namespace Cortex\Tenantable\Policies;

use Rinvex\Fort\Contracts\UserContract;
use Rinvex\Tenantable\Contracts\TenantContract;
use Illuminate\Auth\Access\HandlesAuthorization;

class TenantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list tenants.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Contracts\UserContract $user
     *
     * @return bool
     */
    public function list($ability, UserContract $user)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can create tenants.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Contracts\UserContract $user
     *
     * @return bool
     */
    public function create($ability, UserContract $user)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can update the tenant.
     *
     * @param string                                      $ability
     * @param \Rinvex\Fort\Contracts\UserContract         $user
     * @param \Rinvex\Tenantable\Contracts\TenantContract $resource
     *
     * @return bool
     */
    public function update($ability, UserContract $user, TenantContract $resource)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can update tenants
    }

    /**
     * Determine whether the user can delete the tenant.
     *
     * @param string                                      $ability
     * @param \Rinvex\Fort\Contracts\UserContract         $user
     * @param \Rinvex\Tenantable\Contracts\TenantContract $resource
     *
     * @return bool
     */
    public function delete($ability, UserContract $user, TenantContract $resource)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can delete tenants
    }
}
