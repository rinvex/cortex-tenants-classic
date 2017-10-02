<?php

declare(strict_types=1);

namespace Cortex\Tenants\Http\Middleware;

use Closure;

class Tenantable
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $subdomain = $request->route('subdomain');
        $tenant = app('rinvex.tenants.tenant')->where('slug', $subdomain)->first();

        if ($subdomain && ! $tenant) {
            return intend([
                'url' => route('guestarea.home'),
                'with' => ['warning' => trans('cortex/tenants::messages.tenant.not_found', ['tenantSlug' => $subdomain])],
            ]);
        }

        // unBind {subdomain} route parameter
        ! $request->route('subdomain') || $request->route()->forgetParameter('subdomain');

        // Activate current tenant
        ! $tenant || config(['rinvex.tenants.tenant.active' => $tenant]);

        return $next($request);
    }
}
