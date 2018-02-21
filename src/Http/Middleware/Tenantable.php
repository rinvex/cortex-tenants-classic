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
        $tenant = app('rinvex.tenants.tenant')->where('name', $subdomain)->first();

        if ($subdomain && ! $tenant) {
            return intend([
                'url' => route('frontarea.home'),
                'with' => ['warning' => trans('cortex/foundation::messages.resource_not_found', ['resource' => 'tenant', 'id' => $subdomain])],
            ]);
        }

        // Scope bouncer
        (! $tenant || ! app()->bound(\Silber\Bouncer\Bouncer::class)) || app(\Silber\Bouncer\Bouncer::class)->scope()->to($tenant->getKey());

        // unBind {subdomain} route parameter
        ! $request->route('subdomain') || $request->route()->forgetParameter('subdomain');

        // Activate current tenant
        ! $tenant || config(['rinvex.tenants.active' => $tenant]);

        return $next($request);
    }
}
